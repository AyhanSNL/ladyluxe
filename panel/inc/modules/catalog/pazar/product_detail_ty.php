<?php
$pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
$pazarYeri->execute();
$pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
$currentURL = $ayar['panel_url'].'pages.php?'.$_SERVER['QUERY_STRING'];
$_SESSION['current_url'] = $currentURL;
$currentMenu = 'products';
$currentTab = 'ty';

$urunBilgisi = $db->prepare("select * from urun where id=:id and dil=:dil ");
$urunBilgisi->execute(array(
        'id' => $_GET['productID'],
        'dil' => $_SESSION['dil'],
));
if($urunBilgisi->rowCount()>'0' ) {
    $row = $urunBilgisi->fetch(PDO::FETCH_ASSOC);
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=products');
    exit();
}


$bilgUrun = $db->prepare("select * from trendyol_urun_bilgi where urun_id=:urun_id ");
$bilgUrun->execute(array(
        'urun_id' => $row['id']
));
$bilgi = $bilgUrun->fetch(PDO::FETCH_ASSOC);


$ozellikcek = $bilgi['ty_ozellik'];
$ozellikcek = explode('|', $ozellikcek);

$ozellikcekValue = $bilgi['ty_ozellik'];
$ozellikcekValue = explode('|', $ozellikcekValue);

if(isset($_GET['merchant'])  ) {
    if ($yetki['demo'] != '1') {
            if($_GET['merchant'] == 'stockupdate' ) {


                function replace_tr($text) {
                    $text = trim($text);
                    $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
                    $replace = array('C','c','G','G','i','I','O','o','S','s','U','u');
                    $new_text = str_replace($search,$replace,$text);
                    return $new_text;
                }


                $urunKontrolet = $db->prepare("select ty_kod,id from trendyol_urun_bilgi where urun_id=:urun_id ");
                $urunKontrolet->execute(array(
                    'urun_id' => $_GET['productID']
                ));
                if($urunKontrolet->rowCount()>'0') {
                    $kontrolRow = $urunKontrolet->fetch(PDO::FETCH_ASSOC);
                    if ($kontrolRow['ty_kod'] == !null) {

                        $kodcek = $kontrolRow['ty_kod'];
                        $tyKod = replace_tr($kodcek);

                        $supplierId = ''.$pazar['ty_bayi'].'';
                        $username = ''.$pazar['ty_api'].'';
                        $password = ''.$pazar['ty_secret'].'';
                        $authorization = base64_encode($username . ':' . $password);

                        $curl = curl_init();

                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$supplierId.'/products?barcode='.$tyKod.'',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT =>0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'User-Agent: ' . $supplierId . ' - SelfIntegration',
                                'Authorization: Basic ' . $authorization,
                            )
                        ));

                        $ProductResult = curl_exec($curl);

                        curl_close($curl);
                        $json = json_decode($ProductResult,true);

                        if($json['totalElements'] == '0' ) {
                            $_SESSION['main_alert']= 'ty_stok_alert';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
                            exit();
                        }

                        if($json['totalElements'] == '1' ) {
$timestamp = date('Y-m-d G:i:s');
                            $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_tarih=:ty_tarih,
                                    ty_stok=:ty_stok,
                                    ty_fiyat=:ty_fiyat
                             WHERE urun_id={$_GET['productID']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                    'ty_tarih' => $timestamp,
                                'ty_stok' => $json['content'][0]['quantity'],
                                'ty_fiyat' => $json['content'][0]['salePrice']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert']= 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
                            }else{
                            echo 'Veritabanı Hatası';
                            }

                        }


                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
                    exit();
                }
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
            exit();
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
        exit();
    }
}


if(isset($_GET['send'])  ) {
    if ($yetki['demo'] != '1') {
        if ($_GET['send'] == 'no' || $_GET['send'] == 'yes') {

            if($_GET['send']=='yes'  ) {
                if($bilgUrun->rowCount()<='0'  ) {
                    $kaydet = $db->prepare("INSERT INTO trendyol_urun_bilgi SET
                                              urun_id=:urun_id,  
                                              ty_kat=:ty_kat,
                                              ty_marka=:ty_marka,
                                              ty_ozellik=:ty_ozellik,
                                              ty_izin=:ty_izin
                                        ");
                    $sonuc = $kaydet->execute(array(
                        'urun_id' => $row['id'],
                        'ty_kat' => '0',
                        'ty_marka' => '0',
                        'ty_ozellik' => '0',
                        'ty_izin' => '1'
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
                        exit();
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                    ty_izin=:ty_izin 
              WHERE urun_id={$_GET['productID']}      
             ");
                    $sonuc = $guncelle->execute(array(
                        'ty_izin' => '1'
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
                        exit();
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }
            }else{
                $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                    ty_izin=:ty_izin 
              WHERE urun_id={$_GET['productID']}      
             ");
                $sonuc = $guncelle->execute(array(
                    'ty_izin' => '0'
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
                    exit();
                }else{
                    echo 'Veritabanı Hatası';
                }
            }

        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
            exit();
        }
    }else{
        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_GET['productID'].'');
        exit();
    }
}


?>
<title><?=$row['baslik']?> <?=$diller['adminpanel-form-text-1799']?> - <?=$panelayar['baslik']?></title>
<div class="wrapper" style="margin-top: 0;">
    <div class="container-fluid">


        <!-- Page-Title -->
        <div class="row mb-3">
            <div class="col-md-12 ">
                <div class="page-title-box bg-white card mb-0 pl-3" >
                    <div class="row align-items-center" >
                        <div class="col-md-12" >
                            <div class="page-title-nav">
                                <a href="<?=$ayar['panel_url']?>"><i class="ion ion-md-home"></i> <?=$diller['adminpanel-text-341']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-2']?></a>
                                <a href="pages.php?page=products"><i class="fa fa-angle-right"></i><?=$diller['adminpanel-menu-text-3']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$row['baslik']?></a>
                                <a href="javascript:Void(0)"><i class="fa fa-angle-right"></i><?=$diller['pazaryeri-text-13']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <?php if($yetki['katalog'] == '1' && $yetki['urun'] == '1' && $yetki['entegrasyon'] == '1' && $yetki['entegrasyon_pazar'] == '1') { ?>

            <div class="row">

                <?php include 'inc/modules/_helper/catalog_leftbar.php'; ?>

                <!-- Contents !-->

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body ">
                                    <div class="new-buttonu-main-top mb-0  pb-2 ">
                                        <div class="new-buttonu-main-left w-100">
                                            <a href="pages.php?page=products" class="btn btn-outline-dark  mb-2 btn-sm  " >
                                                <i class="fa fa-arrow-left"></i> <?=$diller['adminpanel-text-138']?>
                                            </a>
                                            <div style="font-size: 20px; font-weight: 600; width: 100%;  " class="d-flex align-items-center justify-content-between flex-wrap pt-2 pb-2">
                                                <div>
                                                    <div>
                                                        <?=$row['baslik']?>
                                                        <a href="<?=$ayar['site_url']?><?=$row['seo_url']?>-P<?=$row['id']?>" target="_blank">
                                                            <i class="fa fa-external-link-alt"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <?php include 'inc/modules/catalog/pazar/product_pazaryeri_tabs.php'; ?>
                                    <div class="tab-content bg-white rounded-bottom border border-top-0">
                                        <div class="tab-pane active p-3" id="one" role="tabpanel" >
                                            <div class="row">
                                                <?php if($pazar['ty_durum'] == '1' ) {?>


                                                    <?php if($bilgi['ty_kat'] == '0' ) {?>
                                                        <div class="col-md-12">
                                                            <div class="w-100 p-3 bg-light mb-3 font-12 rounded border ">
                                                                <i class="fa fa-info-circle mr-1"></i> <?=$diller['pazaryeri-text-77']?>
                                                            </div>
                                                            <div class="w-100 d-flex align-items-center justify-content-center pt-4 pb-4 border">
                                                                <a href="javascript:Void(0)" data-page="product" data-pro="<?=$row['id']?>" data-id="<?=$row['iliskili_kat']?>" class="btn btn-lg btn-success syncDO"><i class="fa fa-sync mr-2"></i> <?=$diller['pazaryeri-text-9']?></a>
                                                            </div>
                                                        </div>
                                                    <?php }else {?>
                                                        <div class="col-md-12">

                                                            <!-- Hata veya Success Logları !-->
                                                            <?php if($bilgi['ty_log'] != '0' && $bilgUrun->rowCount()>'0'  ) {?>
                                                                <div class="rounded  bg-light border p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                                                    <strong><?=$diller['pazaryeri-text-30']?> :</strong>
                                                                    <div class="w-100 border border-light">
                                                                        <?php
                                                                        $josns = json_decode($bilgi['ty_log']);
                                                                        echo'<pre>';
                                                                        print_r($josns);
                                                                        echo'<pre>';
                                                                        if(!isset($josns[0])  ) {
                                                                         echo $bilgi['ty_log'];
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="w-100 pt-2 mt-2 border-top" style="font-size: 11px ;">
                                                                        <?=$diller['adminpanel-form-text-1356']?> : <?php echo date_tr('j F Y, H:i', ''.$bilgi['ty_tarih'].''); ?>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                            <!--  <========SON=========>>> Hata veya Success Logları SON !-->

                                                            <!-- Kustom kutuları !-->
                                                            <?php if( $bilgi['ty_aktarim'] != '1' && $bilgi['ty_kod'] <='0') {?>
                                                                <div class="rounded  border border-grey p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                                                    <div class="kustom-checkbox">
                                                                        <?php if($bilgi['ty_izin'] == '1' ) {?>
                                                                            <input type="checkbox" class="individual" id="izin"  onclick="javascript:window.location='pages.php?page=product_detail_entegration_ty&productID=<?=$row['id']?>&send=no'" <?php if($bilgi['ty_izin'] == '1' ) { ?>checked<?php }?> >
                                                                            <label for="izin"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                <?=$diller['pazaryeri-text-17']?>
                                                                            </label>
                                                                        <?php }else { ?>
                                                                            <input type="checkbox" class="individual" id="izin"  onclick="javascript:window.location='pages.php?page=product_detail_entegration_ty&productID=<?=$row['id']?>&send=yes'" >
                                                                            <label for="izin"  class="d-flex align-items-center justify-content-start" style="font-weight: 200;font-size: 14px ; ">
                                                                                <?=$diller['pazaryeri-text-17']?>
                                                                            </label>
                                                                        <?php }?>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                            <!--  <========SON=========>>> Kustom kutuları SON !-->

                                                            <!-- Ürünü Manuel Mağazaya Ekle Alanı !-->
                                                            <?php if($bilgi['ty_ozellik'] == !null && $bilgi['ty_aktarim'] != '1' && $bilgi['ty_izin'] == '1' && $bilgi['ty_kod'] <= '0') {?>
                                                                <div class="rounded  pt-4 pb-4 pl-3 pr-3 w-100 d-flex align-items-center justify-content-between flex-wrap mb-3 border border-warning" style="background-color: #FFEABB;" >
                                                                    <div style="font-size: 16px ; font-weight: 500;">
                                                                        <?=$diller['pazaryeri-text-90']?>
                                                                    </div>
                                                                    <div class="d-sm-block mt-2 mb-2">
                                                                        <a href="javascript:Void(0)" data-id="<?=$row['id']?>"  class="btn btn-light btn-lg w-100 aktar d-flex align-items-center justify-content-center " href="" style="margin-left: auto;">
                                                                            <img src="assets/images/ty.png" class="mr-2"> <?=$diller['pazaryeri-text-19']?>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            <?php }?>
                                                        </div>
                                                        <!--  <========SON=========>>> Ürünü Manuel Mağazaya Ekle Alanı SON !-->
                                                        
                                                        
                                                        <!-- Ürün Eklenmiş! Bilgileri göster ve update butonu yer alsın !-->
                                                        <?php if($bilgi['ty_kod'] > '0' && $bilgi['ty_izin'] == '1') {
                                                            ?>
                                                           <div class="col-md-12">

                                                               <div class="rounded bg-success text-white  pt-4 pb-4 pl-3 pr-3 w-100 d-flex align-items-center justify-content-between flex-wrap "  >

                                                                   <div style="font-size: 18px ; font-weight: 500;">
                                                                       <?=$diller['pazaryeri-text-92']?>
                                                                       <div class="w-100" style="font-size: 12px ;">
                                                                           <?=$diller['adminpanel-form-text-1356']?> : <?php echo date_tr('j F Y, H:i', ''.$bilgi['ty_tarih'].''); ?>
                                                                       </div>
                                                                   </div>
                                                                   <div class="mt-2 mb-2 d-flex align-items-center justify-content-end flex-wrap">
                                                                       <a href="javascript:Void(0)" data-id="<?=$bilgi['id']?>"  class="btn btn-pink btn-lg w-100 guncelle rounded" href="" >
                                                                           <?=$diller['pazaryeri-text-22']?>
                                                                       </a>
                                                             
                                                                   </div>
                                                                   <div class="w-100 bg-light rounded pt-4 pb-4 pl-1 pr-1 text-dark mt-3">
                                                                       <ul style="margin-bottom: 0;">
                                                                         <?=$diller['pazaryeri-text-91']?>
                                                                       </ul>
                                                                   </div>
                                                               </div>

                                                               <div class="rounded bg-light   pt-4 pb-4 pl-3 pr-3 w-100 mt-3 d-flex align-items-center justify-content-between flex-wrap "  >
                                                                   <div style="font-size: 14px ;">
                                                                       Barcode : <?=$bilgi['ty_kod']?>
                                                                       <br>
                                                                       <?=$diller['pazaryeri-text-119']?> : <strong><?php echo number_format($bilgi['ty_fiyat'], 2); ?> TRY</strong>
                                                                       <br>
                                                                       <?=$diller['pazaryeri-text-93']?> : <strong><?=$bilgi['ty_stok']?></strong>
                                                                       <i class="ti-help-alt text-dark ml-1 " data-toggle="tooltip" data-placement="top" title="<?=$diller['pazaryeri-text-95']?>"></i>
                                                                   </div>
                                                                   <div class="mt-2 mb-2 d-flex align-items-center justify-content-end flex-wrap">
                                                                       <a id="waitButton"  href="pages.php?page=product_detail_entegration_ty&productID=<?=$row['id']?>&merchant=stockupdate" class="btn btn-sm btn-dark btn-lg w-100 mt-2">
                                                                           <?=$diller['pazaryeri-text-94']?>
                                                                       </a>
                                                                   </div>
                                                               </div>
                                                           </div>

                                                        <?php }?>
                                                        <!--  <========SON=========>>> Ürün Eklenmiş! Bilgileri göster ve update butonu yer alsın SON !-->
                                                        
                                                    <?php }?>



                                                    
                                                    
                                                    <!-- Özellikleri Göster !-->
                                                    <?php
                                                    if($bilgi['ty_kat'] !='0' && $bilgi['ty_izin'] == '1' && $bilgi['ty_kod']  <='0' ) {
                                                        $fileCheck = file_get_contents(''.$ayar['panel_url'].'assets/ty/ozellik/'.$bilgi['ty_kat'].'.php');
                                                        $attrb= json_decode($fileCheck);
                                                        $att_area= json_decode($fileCheck,true); ?>
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <!-- Marka Col !-->
                                                                <div class="col-md-4">
                                                                    <div class="rounded border border-grey p-3 w-100 mb-3" style="font-size: 14px ;">
                                                                        <div class="in-header-page-main2">
                                                                            <div class="in-header-page-text2 text-primary">
                                                                                <i class="fa fa-arrow-down"></i>
                                                                                <?=$diller['pazaryeri-text-81']?>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Marka Eklenmemişse uyar !-->
                                                                        <?php if($bilgi['ty_marka'] == '0' || $bilgi['ty_marka'] == null  ) {?>
                                                                            <div class="rounded bg-danger text-white p-3 w-100 " style="font-size: 14px ;">
                                                                                <i class="fa fa-arrow-down"></i> <?=$diller['pazaryeri-text-88']?>
                                                                            </div>
                                                                        <?php }?>
                                                                        <!--  <========SON=========>>> Marka Eklenmemişse uyar SON !-->

                                                                        <?php if(isset($_GET['markaAra']) && $_GET['markaAra'] == !null ) {?>
                                                                            <!-- Arama yapıldı. Sonuçları Getir. !-->
                                                                            <div class="row">
                                                                                <div class="col-md-12 form-group">
                                                                                    <div class="alert-secondary   p-3 rounded mb-2" style="font-size: 13px ;">
                                                                                        <strong><?=$_GET['markaAra']?></strong> <?=$diller['pazaryeri-text-86']?>
                                                                                        <br><br>
                                                                                        <a class="btn btn-dark btn-sm " href="pages.php?page=product_detail_entegration_ty&productID=<?=$row['id']?>">
                                                                                            <i class="fa fa-arrow-left"></i> <?=$diller['pazaryeri-text-85']?>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <form method="post" action="post.php?process=ty_post&status=ty_marka_ekle">
                                                                                <input type="hidden" name="urun_id" value="<?=$row['id']?>" >
                                                                                <input type="hidden" name="return" value="product" >
                                                                                <div class="row">
                                                                                    <div class="col-md-12 form-group">
                                                                                        <?php
                                                                                        $markaURLSearch = file_get_contents('https://api.trendyol.com/sapigw/brands/by-name?name='.urlencode($_GET['markaAra']).'');
                                                                                        $markaSearch= json_decode($markaURLSearch);
                                                                                        ?>
                                                                                        <label for=""><?=$diller['pazaryeri-text-87']?></label>
                                                                                        <br>
                                                                                        <select name="ty_marka_post" class="form-control selet2" required>
                                                                                            <?php foreach ($markaSearch as $mark ) {?>
                                                                                                <option value="<?=$mark->id?>_<?=$mark->name?>"><?=$mark->name?></option>
                                                                                            <?php }?>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-12 form-group mb-0 mt-2">
                                                                                        <button class="btn btn-block  btn-success " name="attAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <!--  <========SON=========>>> Arama yapıldı. Sonuçları Getir. SON !-->
                                                                        <?php }else {?>
                                                                            <!-- Arama Yaptırma Formu !-->
                                                                            <form method="GET" action="pages.php">
                                                                                <input type="hidden" name="page" value="product_detail_entegration_ty" >
                                                                                <input type="hidden" name="productID" value="<?=$row['id']?>" >
                                                                                <div class="row">
                                                                                    <div class="col-md-12 form-group">
                                                                                        <?php if($bilgi['ty_marka_adi'] == !null ) {?>
                                                                                            <div class=" alert-info  text-dark p-3 rounded">
                                                                                                <?php
                                                                                                $markaCevir  = $diller['pazaryeri-text-82'];
                                                                                                $eskiMarka   = '{marka}';
                                                                                                $yeniMarka   = '<strong>'.$bilgi['ty_marka_adi'].'(#'.$bilgi['ty_marka'].')</strong>';
                                                                                                $markaCevir = str_replace($eskiMarka, $yeniMarka, $markaCevir);
                                                                                                ?>
                                                                                                <?=$markaCevir?>
                                                                                            </div>
                                                                                        <?php }?>
                                                                                    </div>
                                                                                    <div class="col-md-12 form-group">
                                                                                        <label for="ara"><?=$diller['pazaryeri-text-83']?></label>
                                                                                        <input type="text" name="markaAra" id="ara" required  autocomplete="off"  class="form-control">
                                                                                    </div>
                                                                                    <div class="col-md-12 form-group mb-0 mt-2">
                                                                                        <button class="btn btn-block  btn-success "><?=$diller['pazaryeri-text-84']?></button>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <!--  <========SON=========>>> Arama Yaptırma Formu SON !-->
                                                                        <?php }?>


                                                                    </div>
                                                                </div>
                                                                <!--  <========SON=========>>> Marka Col SON !-->


                                                                <!-- Kategori Sekronizasyonu !-->
                                                                <div class="col-md-8">
                                                                    <div class="rounded bg-light border border-grey p-3 w-100 d-flex align-items-center justify-content-start flex-wrap mb-3" style="font-size: 14px ;">
                                                                        <div class="flex-grow-1">
                                                                            <strong> <?=$diller['pazaryeri-text-4']?> :</strong> <?=$bilgi['ty_kat_adi']?> (#<?=$bilgi['ty_kat']?>)
                                                                        </div>
                                                                        <div class="d-sm-block mt-2 mb-2">
                                                                            <a href="javascript:Void(0)" data-page="product" data-pro="<?=$row['id']?>" data-id="<?=$row['iliskili_kat']?>" class="btn btn-secondary w-100 syncDO" href="" style="margin-left: auto;">
                                                                                <i class="fa fa-sync"></i> <?=$diller['pazaryeri-text-5']?>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <?php if($bilgi['ty_ozellik'] == '0' && isset($att_area['categoryAttributes'][0])  ) {?>
                                                                        <div class="rounded bg-danger text-white p-3 mb-3 w-100 " style="font-size: 14px ;">
                                                                            <i class="fa fa-arrow-down"></i> <?=$diller['pazaryeri-text-80']?>
                                                                        </div>
                                                                    <?php }?>
                                                                    <div class="rounded border border-grey p-3 w-100 " style="font-size: 14px ;">
                                                                        <div class="in-header-page-main2">
                                                                            <div class="in-header-page-text2 text-primary">
                                                                                <i class="fa fa-arrow-down"></i>
                                                                                <?=$diller['pazaryeri-text-8']?>
                                                                            </div>
                                                                        </div>
                                                                        <form method="post" action="post.php?process=ty_post&status=ty_ozellik">
                                                                            <input type="hidden" name="cat_id" value="<?=$row['iliskili_kat']?>" >
                                                                            <input type="hidden" name="return" value="product" >
                                                                            <input type="hidden" name="urun_id" value="<?=$row['id']?>" >
                                                                            <div class="row">
                                                                                <?php if(isset($att_area['categoryAttributes'][0])  ) {?>
                                                                                    <?php foreach ($attrb->categoryAttributes as $at) {?>
                                                                                        <div class="col-md-6 form-group">
                                                                                            <label for="<?=$at->attribute->id?>"><?php if($at->required == '1'  ) { ?><span class="text-danger">*</span><?php }?> <?=$at->attribute->name?></label>
                                                                                            <?php if($at->allowCustom == '1'  ) {?>
                                                                                                <input type="text"
                                                                                                    <?php foreach ($ozellikcekValue as $omcV) {
                                                                                                        $omcV2 = $omcV;
                                                                                                        $omcV2 = explode('_', $omcV2);
                                                                                                        foreach ($omcV2 as $a =>$key){
                                                                                                            if($key !='' && $a == '0') {
                                                                                                                if($omcV2[0] == $at->attribute->id  ) { ?>
                                                                                                                    value="<?=$omcV2[1]?>"
                                                                                                                <?php }
                                                                                                            }
                                                                                                        }
                                                                                                        ?>
                                                                                                    <?php }?>
                                                                                                       name="ozellik[<?=$at->attribute->id?>]" id="<?=$at->attribute->id?>" <?php if($at->required == '1'  ) { ?>required <?php } ?> class="form-control">
                                                                                            <?php }else { ?>
                                                                                                <select name="ozellik[<?=$at->attribute->id?>]" class="form-control selet2" style="width: 100%" id="<?=$at->attribute->id?>" <?php if($at->required == '1'  ) { ?>required<?php }?>>
                                                                                                    <?php if($at->required != '1'  ) { ?>
                                                                                                        <option value="" selected><?=$diller['adminpanel-form-text-1222']?></option>
                                                                                                    <?php } ?>
                                                                                                    <?php foreach ($at->attributeValues as $at2) {?>
                                                                                                        <option value="<?=$at2->id?>"
                                                                                                            <?php foreach ($ozellikcek as $omc) {?>
                                                                                                                <?php if($omc == ''.$at->attribute->id.'_'.$at2->id.'' ) {?>
                                                                                                                    selected
                                                                                                                <?php }?>
                                                                                                            <?php }?>
                                                                                                        ><?=$at2->name?></option>
                                                                                                    <?php }?>
                                                                                                </select>
                                                                                            <?php }?>
                                                                                        </div>
                                                                                    <?php }
                                                                                }else { ?>
                                                                                   <?php
                                                                                   //todo eğer attribute yok ise bu alana boş ekle aynı zamanda kategori de de yap bunu
                                                                                   ?>
                                                                                <?php }?>
                                                                                <div class="col-md-12 form-group mb-0 mt-2">
                                                                                    <button class="btn btn-block  btn-success " name="attAdd"><?=$diller['adminpanel-form-text-53']?></button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <!--  <========SON=========>>> Kategori Sekronizasyonu SON !-->

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!--  <========SON=========>>> Özellikleri Göster SON !-->






                                                <?php }else { ?>
                                                    <div class="col-md-12 p-3 text-center">
                                                        <h3><?=$diller['adminpanel-text-136']?></h3>
                                                        <h6><?=$diller['pazaryeri-text-146-2']?></h6>
                                                    </div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script type='text/javascript'>
    $(document).ready(function(){

        $('.aktar').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=ty_tek_aktar',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
    $(document).ready(function(){

        $('.guncelle').click(function(){

            var postID = $(this).data('id');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=ty_tek_guncelle',
                type: 'post',
                data: {postID: postID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
</script>
<script type='text/javascript'>
    $(document).ready(function(){

        $('.syncDO').click(function(){

            var postID = $(this).data('id');
            var turnPage = $(this).data('page');
            var productID = $(this).data('pro');
            // AJAX request
            $.ajax({
                url: 'masterpiece.php?page=tyCatSelect',
                type: 'post',
                data: {postID: postID,turnPage: turnPage,productID: productID},
                success: function(response){
                    $('.modal-editable').html(response);
                    $('#duzenle').modal('show');
                }
            });
        });
    });
    $(document).ready(function() {
        $('.selet2').select2({

        })})
</script>