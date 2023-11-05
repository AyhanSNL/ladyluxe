<?php
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'html';
$fontlar = $db->prepare("select * from fontlar where durum='1' order by sira asc ");
$fontlar->execute();
$htmlModulSql = $db->prepare("select * from html_modul where dil=:dil order by id desc limit 1");
$htmlModulSql->execute(array(
    'dil' => $_SESSION['dil'],
));
use Verot\Upload\Upload;
if(isset($_GET['process']) && $_GET['process'] == !null && $_GET['process'] == 'build'  ) {
    if ($yetki['demo'] != '1') {
        if ($htmlModulSql->rowCount() <= '0') {
            $kaydet = $db->prepare("INSERT INTO html_modul SET
               dil=:dil, 
               bg_tip=:bg_tip,
               bg_color=:bg_color,
               padding=:padding,
               margin=:margin,
               baslik=:baslik,
               ustbaslik=:ustbaslik,
               spot=:spot,
               boxed=:boxed,
               area=:area
        ");
            $sonuc = $kaydet->execute(array(
                'dil' => $_SESSION['dil'],
                'bg_tip' => '1',
                'bg_color' => '#f8f8f8',
                'padding' => '20',
                'margin' => '0',
                'baslik' => 'Başlık',
                'ustbaslik' => 'Üst Başlık',
                'spot' => 'İçerik',
                'boxed' => '1',
                'area' => '2'
            ));
            if ($sonuc) {
                $_SESSION['main_alert'] = 'showcase_html_success';
                header("Refresh:2; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
                exit();
            } else {
                echo 'Veritabanı Hatası';
            }
        } else {
            header('Location:' . $ayar['panel_url'] . 'pages.php?page=showcase_html');
            exit();
        }
    }
}

if(isset($_GET['process']) && $_GET['process'] == !null && $_GET['process'] == 'photo_delete'  ) {
if ($yetki['demo'] != '1') {
    if (isset($_GET['no']) && $_GET['no'] == !null) {
        $sorgu = $db->prepare("select * from html_modul where id='$_GET[no]' ");
        $sorgu->execute();
        $row = $sorgu->fetch(PDO::FETCH_ASSOC);
        if ($sorgu->rowCount() > '0') {
            unlink("../images/uploads/$row[gorsel]");
            $guncelle = $db->prepare("UPDATE html_modul SET
                            gorsel=:gorsel
                     WHERE id='$_GET[no]'      
                    ");
            $sonuc = $guncelle->execute(array(
                'gorsel' => null
            ));
            if ($sonuc) {
                $_SESSION['main_alert'] = 'success';
                header("Refresh:0; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
                 exit();
            } else {
                echo 'Veritabanı Hatası';
            }
        } else {
            header("Refresh:0; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
             exit();
        }
    } else {
        header("Refresh:0; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
         exit();
    }
}
}

if(isset($_GET['process']) && $_GET['process'] == !null && $_GET['process'] == 'photoUpdate'  ) {
if ($yetki['demo'] != '1') {
    if ($_POST && isset($_POST['update'])) {

        if ($_FILES['gorsel']["size"] > 0) {
            error_reporting(0);
            $old_img = $_POST['old_img'];
            $file_format = $_FILES["gorsel"];
            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/svg+xml' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' || $file_format['type'] == 'image/gif' ) {
                /* Görsel Upload */
                include_once('inc/class.upload.php');
                $upload = new Upload($_FILES['gorsel']);
                if ($upload->uploaded) {
                    $random = rand(0, (int)99991234569);
                    $random2 = rand(0, (int)999);
                    $upload->file_name_body_pre = 'banner_image_';
                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                    $upload->process("../images/uploads");
                    $file_name = $upload->file_dst_name;
                }
                /*  <========SON=========>>> Görsel Upload SON */
                $guncelle = $db->prepare("UPDATE html_modul SET
                                 gorsel=:gorsel
                     WHERE id={$_POST['modul_id']}      
                    ");
                $sonuc = $guncelle->execute(array(
                    'gorsel' => $file_name
                ));
                if ($sonuc) {
                    if ($old_img == !null || isset($old_img)) {
                        unlink("../images/uploads/$old_img");
                    }
                    header("Refresh:0; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
                    $_SESSION['main_alert'] = 'success';
                    exit();
                } else {
                    echo 'Veritabanı Hatası';
                }
            } else {
                header("Refresh:1; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
                $_SESSION['main_alert'] = 'filetype';
                exit();

            }
        } else {
            header("Refresh:1; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
            $_SESSION['main_alert'] = 'filesize';
            exit();
        }

    } else {
        header("Refresh:0; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
        exit();
    }
}
}

/* Main Update */
if(isset($_GET['process']) && $_GET['process'] == !null && $_GET['process'] == 'mainUpdate'  ) {
if ($yetki['demo'] != '1') {
    if ($_POST && isset($_POST['update'])) {
        function colorFormat($degisken)
        {
            $isim = $degisken;
            $eski = '#';
            $yeni = '';
            $isim = str_replace($eski, $yeni, $isim);
            return $isim;
        }

        $guncelle = $db->prepare("UPDATE html_modul SET
                baslik=:baslik,
                baslik_renk=:baslik_renk,
                spot=:spot,
                ustbaslik_renk=:ustbaslik_renk,
                ustbaslik=:ustbaslik,
                spot_renk=:spot_renk,
                url=:url,
                button_yazi=:button_yazi,
                button_renk=:button_renk,
                button_size=:button_size,
                yeni_sekme=:yeni_sekme
         WHERE id={$_POST['modul_id']}      
        ");
        $sonuc = $guncelle->execute(array(
            'baslik' => $_POST['baslik'],
            'baslik_renk' => colorFormat($_POST['baslik_renk']),
            'spot' => $_POST['spot'],
            'ustbaslik_renk' => colorFormat($_POST['ustbaslik_renk']),
            'ustbaslik' => $_POST['ustbaslik'],
            'spot_renk' => colorFormat($_POST['spot_renk']),
            'url' => $_POST['url'],
            'button_yazi' => $_POST['button_yazi'],
            'button_renk' => $_POST['button_renk'],
            'button_size' => $_POST['button_size'],
            'yeni_sekme' => $_POST['yeni_sekme']
        ));
        if ($sonuc) {
            header("Refresh:1; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
            $_SESSION['main_alert'] = 'success';
            exit();
        } else {
            echo 'Veritabanı Hatası';
        }

    } else {
        header("Refresh:0; url=" . $ayar['panel_url'] . "pages.php?page=showcase_html");
        exit();
    }
}
}
/*  <========SON=========>>> Main Update SON */

?>
<title><?=$diller['adminpanel-menu-text-72']?> - <?=$panelayar['baslik']?></title>
<style>
    .nav-link{
        color: #000;
        transition-duration: 0.1s; transition-timing-function: linear;
        font-weight: 500;
        font-size: 14px;
        padding: 15px 12px;
    }
    .saas:hover{
        background-color: #fff;
        color: #000;
    }
    @media (max-width: 768px) {
        .nav-tabs{
            overflow-x: scroll;
            flex-wrap: nowrap;
            text-align: center;
            padding-bottom: 5px;
        }
        .nav-link.active{
            border-color: #dee2e6 #dee2e6 #dee2e6 !important;
            border-radius: 10px !important;
        }
    }
</style>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">


        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center d-flex justify-content-between" >
                        <div class="col-md-8" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-67']?></a>
                                <a href="pages.php?page=showcase_html"><i class="fa fa-angle-right"></i> <?=$diller['adminpanel-menu-text-72']?></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->



        <?php if($yetki['modul'] == '1' &&  $yetki['modul_vitrin'] == '1') {
            ?>

            <div class="row">

                <?php include 'inc/modules/_helper/modules_leftbar.php'; ?>

                <!-- Contents !-->
                <div class="<?php if($panelayar['panel_nav'] == '1'   ) { ?>col-md-9<?php }else{?>col-md-12<?php } ?>">


                    <?php if($htmlModulSql->rowCount()<='0'  ) {?>
                        <div class="w-100 border d-flex p-3 align-items-center justify-content-center bg-white flex-wrap" style="height: 300px">
                          <div class="w-100 text-center">
                              <h5><?=$diller['adminpanel-form-text-984']?></h5>
                              <br>
                              <a href="pages.php?page=showcase_html&process=build" class="btn btn-dark btn-lg p-3 pl-4 pr-4"><?=$diller['adminpanel-form-text-985']?></a>
                          </div>
                        </div>
                    <?php }else {

                        $row = $htmlModulSql->fetch(PDO::FETCH_ASSOC);

                        ?>
                        <!-- Tab headers !-->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <!-- İçerik Ayarları Tab !-->
                            <li class="nav-item">
                                <a class="nav-link saas  active" id="content-set-tab" data-toggle="tab" href="#content-set" role="tab" aria-controls="other" aria-selected="true">
                                    <div ><?=$diller['adminpanel-form-text-981']?></div>
                                </a>
                            </li>
                            <!--  <========SON=========>>> İçerik Ayarları Tab SON !-->

                            <!-- Arkaplan Ayarları Tab !-->
                            <li class="nav-item">
                                <a class="nav-link saas" id="background-set-tab" data-toggle="tab" href="#background-set" role="tab" aria-controls="background" aria-selected="true">
                                    <div ><?=$diller['adminpanel-form-text-263']?></div>
                                </a>
                            </li>
                            <!--  <========SON=========>>> Arkaplan Ayarları Tab SON !-->

                            <!-- Diğer Ayarlar !-->
                            <li class="nav-item">
                                <a class="nav-link saas" id="other-set-tab" data-toggle="tab" href="#other-set" role="tab" aria-controls="other" aria-selected="true">
                                    <div ><?=$diller['adminpanel-form-text-982']?></div>
                                </a>
                            </li>
                            <!--  <========SON=========>>> Diğer Ayarlar SON !-->

                        </ul>
                        <!--  <========SON=========>>> Tab headers SON !-->

                        <!-- Tab Contents !-->
                        <div class="tab-content bg-white border border-top-0 rounded-bottom">


                            <!-- İçerik tab !-->
                            <div class="tab-pane  active p-3 " id="content-set" role="tabpanel" >
                                <div class="row  pl-2 pr-2" >
                                    <!-- Görsel !-->
                                    <div class="col-md-12">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="in-header-page-main">
                                                    <div class="in-header-page-text">
                                                        <?=$diller['adminpanel-form-text-107']?>
                                                    </div>
                                                </div>

                                                <div class="w-100  text-center mb-3 ">
                                                    <?php if($row['gorsel'] == !null  ) {?>
                                                        <img class="border p-2" src="<?=$ayar['site_url']?>images/uploads/<?=$row['gorsel']?>" style="max-width: 100%">
                                                        <br>
                                                        <a href="" data-href="pages.php?page=showcase_html&process=photo_delete&no=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger mt-2"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                    <?php }else { ?>
                                                        <img src="assets/images/no-img.jpg" class="img-fluid border p-1" style=" height: 100px; " >
                                                    <?php }?>
                                                </div>

                                                <div class="w-100">
                                                    <form action="pages.php?page=showcase_html&process=photoUpdate" method="post" enctype="multipart/form-data">
                                                        <input type="hidden" name="old_img" value="<?=$row['gorsel']?>" >
                                                        <input type="hidden" name="modul_id" value="<?=$row['id']?>" >
                                                        <div class="input-group mb-3">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="gorsel" >
                                                                <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-success btn-block" name="update"><i class="fa fa-upload"></i> <?=$diller['adminpanel-text-144']?></button>
                                                        <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                                            <small>png,  jpg, jpeg, svg, gif</small>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  <========SON=========>>> Görsel SON !-->
                                  <!-- İçerik Form !-->
                                    <div class="col-md-12">
                                        <form action="pages.php?page=showcase_html&process=mainUpdate" method="post">
                                            <input type="hidden" name="modul_id" value="<?=$row['id']?>">
                                        <div class="card border">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8 form-group">
                                                        <label for="ustbaslik"><?=$diller['adminpanel-form-text-987']?></label>
                                                        <input type="text" name="ustbaslik" value="<?=$row['ustbaslik']?>" id="ustbaslik"   class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="ustbaslik_renk"><?=$diller['adminpanel-form-text-988']?></label>
                                                        <div data-color-format="default" data-color="#<?=$row['ustbaslik_renk']?>"  class="colorpicker-default input-group">
                                                            <input type="text" name="ustbaslik_renk"  value="" class="form-control">
                                                            <div class="input-group-append add-on">
                                                                <button class="btn btn-light border" type="button">
                                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <label for="baslik"><?=$diller['adminpanel-form-text-989']?></label>
                                                        <input type="text" name="baslik" value="<?=$row['baslik']?>" id="baslik"   class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="baslik_renk"><?=$diller['adminpanel-form-text-990']?></label>
                                                        <div data-color-format="default" data-color="#<?=$row['baslik_renk']?>"  class="colorpicker-default input-group">
                                                            <input type="text" name="baslik_renk"  value="" class="form-control">
                                                            <div class="input-group-append add-on">
                                                                <button class="btn btn-light border" type="button">
                                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 form-group">
                                                        <label for="spot"><?=$diller['adminpanel-form-text-901']?></label>
                                                        <textarea name="spot" id="tiny" class="form-control" rows="1"><?=$row['spot']?></textarea>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="spot_renk"><?=$diller['adminpanel-form-text-324']?></label>
                                                        <div data-color-format="default" data-color="#<?=$row['spot_renk']?>"  class="colorpicker-default input-group">
                                                            <input type="text" name="spot_renk"  value="" class="form-control">
                                                            <div class="input-group-append add-on">
                                                                <button class="btn btn-light border" type="button">
                                                                    <i style="background-color: rgb(124, 66, 84);"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="in-header-page-main mt-3">
                                                    <div class="in-header-page-text">
                                                        <?=$diller['adminpanel-form-text-991']?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="url"><?=$diller['adminpanel-form-text-977']?></label>
                                                        <input type="text" name="url" value="<?=$row['url']?>" id="url" placeholder="https://"   class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="button_yazi"><?=$diller['adminpanel-form-text-911']?></label>
                                                        <input type="text" name="button_yazi" value="<?=$row['button_yazi']?>" id="button_yazi"   class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="button_renk"><?=$diller['adminpanel-form-text-863']?></label>
                                                        <select name="button_renk" class="form-control" id="button_renk" required>
                                                            <option value="button-black-white" <?php if($row['button_renk'] == 'button-black-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-156']?> </option>
                                                            <option value="button-white-black" <?php if($row['button_renk'] == 'button-white-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-172']?> </option>
                                                            <option value="button-yellow" <?php if($row['button_renk'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-150']?></option>
                                                            <option value="button-yellow-out" <?php if($row['button_renk'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-151']?></option>
                                                            <option value="button-black" <?php if($row['button_renk'] == 'button-black' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-152']?></option>
                                                            <option value="button-black-out" <?php if($row['button_renk'] == 'button-black-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-153']?></option>
                                                            <option value="button-white" <?php if($row['button_renk'] == 'button-white' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-154']?></option>
                                                            <option value="button-white-out" <?php if($row['button_renk'] == 'button-white-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-155']?> </option>
                                                            <option value="button-gold" <?php if($row['button_renk'] == 'button-gold' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-157']?></option>
                                                            <option value="button-gold-out" <?php if($row['button_renk'] == 'button-gold-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-158']?> </option>
                                                            <option value="button-red" <?php if($row['button_renk'] == 'button-red' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-159']?></option>
                                                            <option value="button-red-out" <?php if($row['button_renk'] == 'button-red-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-160']?> </option>
                                                            <option value="button-blue" <?php if($row['button_renk'] == 'button-blue' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-161']?></option>
                                                            <option value="button-blue-out" <?php if($row['button_renk'] == 'button-blue-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-162']?> </option>
                                                            <option value="button-yellow" <?php if($row['button_renk'] == 'button-yellow' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-163']?></option>
                                                            <option value="button-yellow-out" <?php if($row['button_renk'] == 'button-yellow-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-164']?> </option>
                                                            <option value="button-green" <?php if($row['button_renk'] == 'button-green' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-165']?></option>
                                                            <option value="button-green-out" <?php if($row['button_renk'] == 'button-green-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-166']?> </option>
                                                            <option value="button-grey" <?php if($row['button_renk'] == 'button-grey' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-167']?></option>
                                                            <option value="button-grey-out" <?php if($row['button_renk'] == 'button-grey-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-168']?> </option>
                                                            <option value="button-orange" <?php if($row['button_renk'] == 'button-orange' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-169']?></option>
                                                            <option value="button-orange-out" <?php if($row['button_renk'] == 'button-orange-out' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-170']?> </option>
                                                            <option value="button-pink" <?php if($row['button_renk'] == 'button-pink' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-171']?></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label for="button_size"><?=$diller['adminpanel-form-text-495']?></label>
                                                        <select name="button_size" class="form-control" id="button_size" required>
                                                            <option value="button-1x" <?php if($row['button_size'] == 'button-1x' ) { ?>selected<?php }?>>1x</option>
                                                            <option value="button-2x" <?php if($row['button_size'] == 'button-2x' ) { ?>selected<?php }?>>2x</option>
                                                            <option value="button-3x" <?php if($row['button_size'] == 'button-3x' ) { ?>selected<?php }?>>3x</option>
                                                            <option value="button-4x" <?php if($row['button_size'] == 'button-4x' ) { ?>selected<?php }?>>4x</option>
                                                            <option value="button-5x" <?php if($row['button_size'] == 'button-5x' ) { ?>selected<?php }?>>5x</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select name="yeni_sekme" class="form-control border border-secondary" id="yeni_sekme" required>
                                                            <option value="0" <?php if($row['yeni_sekme'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-858']?></option>
                                                            <option value="1" <?php if($row['yeni_sekme'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-111']?></option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 text-right">
                                                        <button class="btn  btn-success btn-block " name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    </div>                                  
                                  <!--  <========SON=========>>> İçerik Form SON !-->



                                </div>
                            </div>
                            <!--  <========SON=========>>> İçerik tab SON !-->

                            <!-- Arkaplan Ayar tab !-->
                            <div class="tab-pane p-4 " id="background-set" role="tabpanel" >
                                <form action="post.php?process=showcase_post&status=html_modul_bg" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="modul_id" value="<?=$row['id']?>" >
                                    <div class="row">
                                        <div class="form-group col-md-12 ">
                                            <select name="bg_tip" class="form-control"  id="select_box" required>
                                                <option value="0" <?php if($row['bg_tip'] == '0' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-251']?></option>
                                                <option value="1" <?php if($row['bg_tip'] == '1' ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-250']?></option>
                                            </select>
                                        </div>
                                        <div  id="0" class="select_option form-group pl-3 pr-3 w-100">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="inputGroupFile01"><?=$diller['adminpanel-form-text-255']?></label>
                                                    <div class="w-100 bg-light   p-3 text-center mb-3 ">
                                                        <?php if($row['bg_image'] == !null  ) {?>
                                                            <small class="text-dark">
                                                                <?=$diller['adminpanel-form-text-107']?>
                                                            </small>
                                                            <br><br>
                                                            <img src="<?=$ayar['site_url']?>images/uploads/<?=$row['bg_image']?>" class="img-fluid" >
                                                            <small>
                                                                <br><br>
                                                                <?=$diller['adminpanel-form-text-89']?> : 1920x1080
                                                            </small>
                                                            <br><br>
                                                            <a href="" data-href="post.php?process=showcase_post&status=html_modul_bg_delete&modul_id=<?=$row['id']?>"  data-toggle="modal" data-target="#confirm-delete"  class="btn btn-sm btn-danger"><i class="ti-trash"></i> <?=$diller['adminpanel-text-167']?></a>
                                                        <?php }else{ ?>
                                                            <img src="assets/images/no-img.jpg" style="width: 90px" class="border"  >
                                                            <small>
                                                                <br><br>
                                                                <?=$diller['adminpanel-form-text-89']?> : 1920x1080
                                                            </small>
                                                        <?php }?>
                                                    </div>
                                                    <div class="w-100">
                                                        <input type="hidden" name="old_bg" value="<?=$row['bg_image']?>" >
                                                        <div class="input-group mb-3">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="bg_image" >
                                                                <label class="custom-file-label" for="inputGroupFile01"><?=$diller['adminpanel-form-text-106']?></label>
                                                            </div>
                                                        </div>
                                                        <div class="w-100 text-center bg-light rounded text-dark mt-1 ">
                                                            <small>png,  jpg, jpeg</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="in-header-page-main">
                                                        <div class="in-header-page-text">
                                                            <?=$diller['adminpanel-form-text-263']?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group bg-light col-md-12 mb-4 border pb-3 pt-2">
                                                        <label  for="bg_durum" class="w-100" ><?=$diller['adminpanel-form-text-253']?></label>
                                                        <div class="custom-control custom-switch custom-switch-lg">
                                                            <input type="hidden" name="bg_durum" value="0"">
                                                            <input type="checkbox" class="custom-control-input" id="bg_durum" name="bg_durum" value="1"  <?php if($row['bg_durum'] == '1'  ) { ?>checked<?php }?> ">
                                                            <label class="custom-control-label" for="bg_durum"></label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group bg-light col-md-12 mb-4 border pb-3 pt-2">
                                                        <label  for="bg_dark" class="w-100" ><?=$diller['adminpanel-form-text-252']?></label>
                                                        <div class="custom-control custom-switch custom-switch-lg">
                                                            <input type="hidden" name="bg_dark" value="0"">
                                                            <input type="checkbox" class="custom-control-input" id="bg_dark" name="bg_dark" value="1"  <?php if($row['bg_dark'] == '1'  ) { ?>checked<?php }?> ">
                                                            <label class="custom-control-label" for="bg_dark"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="1" class="select_option w-100 ">
                                            <div class="d-flex flex-wrap">
                                                <div class="form-group col-md-12">
                                                    <label for="bg_color"><?=$diller['adminpanel-form-text-254']?></label>
                                                    <div data-color-format="default" data-color="#<?=$row['bg_color']?>"  class="colorpicker-default input-group">
                                                        <input type="text" name="bg_color"  value="" class="form-control">
                                                        <div class="input-group-append add-on">
                                                            <button class="btn btn-light border" type="button">
                                                                <i style="background-color: rgb(124, 66, 84);"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group mb-0">
                                            <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--  <========SON=========>>> Arkaplan Ayar tab SON !-->

                            <!-- Diğer ayarlar !-->
                            <div class="tab-pane p-4 " id="other-set" role="tabpanel" >
                                <form action="post.php?process=showcase_post&status=html_modul_other" method="post" >
                                    <input type="hidden" name="modul_id" value="<?=$row['id']?>" >
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label for="padding"><?=$diller['adminpanel-form-text-130']?></label>
                                            <input type="number" name="padding" value="<?=$row['padding']?>" id="padding"   class="form-control">
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="margin"><?=$diller['adminpanel-form-text-243']?></label>
                                            <input type="number" name="margin" value="<?=$row['margin']?>" id="margin"   class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="modul_border"><?=$diller['adminpanel-form-text-384']?></label>
                                            <div data-color-format="default" data-color="#<?=$row['modul_border']?>"  class="colorpicker-default input-group">
                                                <input type="text" name="modul_border"  value="" class="form-control">
                                                <div class="input-group-append add-on">
                                                    <button class="btn btn-light border" type="button">
                                                        <i style="background-color: rgb(124, 66, 84);"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="area"><?=$diller['adminpanel-form-text-992']?></label>
                                            <select name="area" class="form-control" id="area" required>
                                                <option value="1" <?php if($row['area'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-208']?></option>
                                                <option value="0" <?php if($row['area'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-209']?></option>
                                                <option value="2" <?php if($row['area'] == '2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-210']?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label  for="baslik_font" class="w-100"><?=$diller['adminpanel-form-text-77']?></label>
                                            <select name="baslik_font" class="form-control" id="baslik_font" >
                                                <?php foreach ($fontlar as $font) {?>
                                                    <option value="<?=$font['font_adi']?>" <?php if($font['font_adi'] == $row['baslik_font'] ) { ?>selected<?php }?>><?=$font['font_adi']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label  for="baslik_space" class="w-100">* <?=$diller['adminpanel-form-text-560']?></label>
                                            <select name="baslik_space" class="form-control" id="baslik_space" >
                                                <option value="" <?php if($row['baslik_space'] == ''  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-401']?></option>
                                                <option value="lspac" <?php if($row['baslik_space'] == 'lspac'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-398']?></option>
                                                <option value="lspacsmall" <?php if($row['baslik_space'] == 'lspacsmall'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-399']?></option>
                                                <option value="lspacsmall_2" <?php if($row['baslik_space'] == 'lspacsmall_2'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-400']?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="boxed"><?=$diller['adminpanel-form-text-993']?></label>
                                            <select name="boxed" class="form-control" id="boxed" required>
                                                <option value="0" <?php if($row['boxed'] == '0'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-994']?></option>
                                                <option value="1" <?php if($row['boxed'] == '1'  ) { ?>selected<?php }?>><?=$diller['adminpanel-form-text-995']?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 mb-4">
                                            <label  for="round" class="w-100" ><?=$diller['adminpanel-form-text-1960']?></label>
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="hidden" name="round" value="0"">
                                                <input type="checkbox" class="custom-control-input" id="round" name="round" value="1"  <?php if($row['round'] == '1'  ) { ?>checked<?php }?> ">
                                                <label class="custom-control-label" for="round"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group mb-0">
                                            <button class="btn  btn-success btn-block" name="update"><?=$diller['adminpanel-form-text-53']?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--  <========SON=========>>> Diğer ayarlar SON !-->


                        </div>
                        <!--  <========SON=========>>> Tab Contents SON !-->
                    <?php }?>





                </div>
                <!--  <========SON=========>>> Contents SON !-->



            </div>



        <?php }else { ?>
            <div class="card p-xl-5">
                <h3><?=$diller['adminpanel-text-136']?></h3>
                <h6><?=$diller['adminpanel-text-137']?></h6>
                <div  class="mt-3">
                    <a href="<?=$ayar['panel_url']?>" class="btn btn-primary"><?=$diller['adminpanel-text-138']?></a>
                </div>
            </div>
        <?php }?>
    </div>
</div>


<script>
    $('[data-toggle="tab"]').click(function(e) {

        var $this = $(this),

            loadurl = $this.attr('href'),
            targ = $this.attr('data-toggle');


        $.get(loadurl, function(data) {
            $(targ).html(data);
        });

        $this.tab('show');

        return false;

    });
    $('#select_box').change(function () {
        var select = $(this).find(':selected').val();
        $(".select_option").hide();
        $('#' + select).show();
    }).change();
</script>
<script type="text/javascript">
    <?php if($_SESSION['tab_select'] == 'other'  ) {?>
    $('#other-set-tab').addClass('active');
    $('#other-set').addClass('active');

    $('#content-set-tab').removeClass('active');
    $('#content-set').removeClass('active');
    <?php
    unset($_SESSION['tab_select']);
    ?>
    <?php }?>
    <?php if($_SESSION['tab_select'] == 'bg'  ) {?>
    $('#background-set-tab').addClass('active');
    $('#background-set').addClass('active');

    $('#content-set-tab').removeClass('active');
    $('#content-set').removeClass('active');
    <?php
    unset($_SESSION['tab_select']);
    ?>
    <?php }?>
</script>

