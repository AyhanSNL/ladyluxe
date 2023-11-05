<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;

$pazarDevSql = $db->prepare("select hb_user,hb_pass,hb_merchant from pazaryeri where id=:id ");
$pazarDevSql->execute(array(
    'id' => '1'
));
$pazarDevRow = $pazarDevSql->fetch(PDO::FETCH_ASSOC);


$hbuser = $pazarDevRow['hb_user'];
$hbpass = $pazarDevRow['hb_pass'];
$hbmerchant = $pazarDevRow['hb_merchant'];

if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'hb_settings'
            || $_GET['status'] == 'hb_inventory_item_add'
            || $_GET['status'] == 'hb_track_control'
            || $_GET['status'] == 'hb_toplu_urun_gonder'
            || $_GET['status']=='hb_track_delete'
            || $_GET['status']=='hb_eslestir'
            || $_GET['status']=='ty_urun_cek'
            || $_GET['status']=='ty_sistemden_urun_sil'
            || $_GET['status']=='hb_ozellik'
            || $_GET['status']=='ty_marka_ekle'
            || $_GET['status']=='ty_tekguncelle'
            || $_GET['status']=='ty_aktarim') {


            if($_GET['status'] == 'hb_inventory_item_add'  ) {

                $invSql = $db->prepare("select id from hb_envanter where urun_id=:urun_id ");
                $invSql->execute(array(
                    'urun_id' => $_POST['inv_product_id'],
                ));

                if($invSql->rowCount()>'0'  ) {
                    $_SESSION['main_alert'] = 'hb_inv_item_var';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                    exit();
                }else{
                    $Varmi = $db->prepare("select * from hb_urun_bilgi where urun_id=:urun_id ");
                    $Varmi->execute(array(
                        'urun_id' => $_POST['inv_product_id']
                    ));
                    $varrow = $Varmi->fetch(PDO::FETCH_ASSOC);
                    if($Varmi->rowCount()<='0'  ) {
                        $urunc = $db->prepare("select fiyat, stok, barkod, urun_kod from urun where id=:id ");
                        $urunc->execute(array(
                            'id' => $_POST['inv_product_id']
                        ));
                        $urun = $urunc->fetch(PDO::FETCH_ASSOC);

                        if($urun['barkod'] == !null ) {
                            $barkod = $urun['barkod'];
                        }else{
                            $barkod = $urun['urun_kod'];
                        }

                        if($_POST['sku_durum'] == '1'  ) {
                            $sku = $_POST['hb_sku'];
                            $msku = $_POST['hb_stokkodu'];
                        }else{
                            $sku = null;
                        }


                        if($_POST['sku_durum'] == '1'  ) {
                            if($_POST['hb_sku'] == null  ) {
                                $_SESSION['main_alert'] = 'hb_sku_bos';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                                exit();
                            }
                            if($_POST['hb_stokkodu'] == null  ) {
                                $_SESSION['main_alert'] = 'hb_stokkod_bos';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                                exit();
                            }
                        }

                        $timestamp = date('Y-m-d G:i:s');
                        $kaydet = $db->prepare("INSERT INTO hb_envanter SET
                        urun_id=:urun_id,
                        hb_sku=:hb_sku,
                        hb_stokkodu=:hb_stokkodu,
                        barkod=:barkod,
                        hb_fiyat=:hb_fiyat,
                        hb_stok=:hb_stok,
                        hb_yayin=:hb_yayin,
                        tarih=:tarih
                ");
                        $sonuc = $kaydet->execute(array(
                            'urun_id' => $_POST['inv_product_id'],
                            'hb_sku' => $sku,
                            'hb_stokkodu' => $msku,
                            'barkod' => $barkod,
                            'hb_fiyat' => $urun['fiyat'],
                            'hb_stok' => $urun['stok'],
                            'hb_yayin' => '0',
                            'tarih' => $timestamp
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                            exit();
                        }else{
                            echo 'Veritabanı Hatası';
                            exit();
                        }
                    }else{
                        if($varrow['hb_aktarim'] == '0' ) {
                            $silmeislem = $db->prepare("DELETE from hb_urun_bilgi WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $_POST['inv_product_id']
                            ));
                            $urunc = $db->prepare("select fiyat, stok, barkod, urun_kod from urun where id=:id ");
                            $urunc->execute(array(
                                'id' => $_POST['inv_product_id']
                            ));
                            $urun = $urunc->fetch(PDO::FETCH_ASSOC);

                            if($urun['barkod'] == !null ) {
                                $barkod = $urun['barkod'];
                            }else{
                                $barkod = $urun['urun_kod'];
                            }


                            if($_POST['sku_durum'] == '1'  ) {
                                if($_POST['hb_sku'] == null  ) {
                                    $_SESSION['main_alert'] = 'hb_sku_bos';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                                    exit();
                                }
                                if($_POST['hb_stokkodu'] == null  ) {
                                    $_SESSION['main_alert'] = 'hb_stokkod_bos';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                                    exit();
                                }
                            }

                            if($_POST['sku_durum'] == '1'  ) {
                                $sku = $_POST['hb_sku'];
                                $msku = $_POST['hb_stokkodu'];
                            }else{
                                $sku = null;
                            }

                            $timestamp = date('Y-m-d G:i:s');
                            $kaydet = $db->prepare("INSERT INTO hb_envanter SET
                        urun_id=:urun_id,
                        hb_sku=:hb_sku,
                        hb_stokkodu=:hb_stokkodu,
                        barkod=:barkod,
                        hb_fiyat=:hb_fiyat,
                        hb_stok=:hb_stok,
                        hb_yayin=:hb_yayin,
                        tarih=:tarih
                ");
                            $sonuc = $kaydet->execute(array(
                                'urun_id' => $_POST['inv_product_id'],
                                'hb_sku' => $sku,
                                'hb_stokkodu' => $msku,
                                'barkod' => $barkod,
                                'hb_fiyat' => $urun['fiyat'],
                                'hb_stok' => $urun['stok'],
                                'hb_yayin' => '0',
                                'tarih' => $timestamp
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                                exit();
                            }else{
                                echo 'Veritabanı Hatası';
                                exit();
                            }
                        }else{
                            $_SESSION['main_alert'] = 'hb_bagli_urun';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=hb_envanter');
                            exit();
                        }
                    }
                }









            }

            if($_GET['status'] == 'hb_track_control'  ) {
                if($_POST  ) {
                    $trID = $_POST['tarih_sec'];
                    $TrackCek = $db->prepare("select * from hb_track where id=:id ");
                    $TrackCek->execute(array(
                        'id' => $trID,
                    ));
                    $trc = $TrackCek->fetch(PDO::FETCH_ASSOC);

                    /* track id ye göre ürünlerin durumları tek tek alınıyor */
                    $istek = 'https://mpop.hepsiburada.com/product/api/products/status/'.$trc['track'].'?page=0&size=10000&version=1';
                    //todo canlı moda geçtiğinde URL'yi düzenle

                    $service_url = $istek;
                    $curl = curl_init($service_url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $header = array(
                        'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                    $curl_response = curl_exec($curl);

                    $trackResult = json_decode($curl_response);

                    foreach ($trackResult->data as $tf){
                        $productCode = $tf->merchantSku;
                        $productStatus = $tf->productStatus;
                        $hbSKU = $tf->hbSku;
                        $UrunGetir = $db->prepare("select * from hb_urun_bilgi where hb_kod=:hb_kod ");
                        $UrunGetir->execute(array(
                            'hb_kod' => $productCode
                        ));
                        //todo canlu moda geçtiğinde LOG kaydını ve veritabanına aktarımını kontrol et
                        $urunS = $UrunGetir->fetch(PDO::FETCH_ASSOC);
                        $guncelle = $db->prepare("UPDATE hb_urun_bilgi SET
                                     hb_durumu=:hb_durumu,
                                     hb_sku=:hb_sku,
                                     hb_log=:hb_log
                                     WHERE id={$urunS['id']}      
                                    ");
                        $sonuc = $guncelle->execute(array(
                            'hb_durumu' => $productStatus,
                            'hb_sku' => $hbSKU,
                            'hb_log' => json_encode($tf->validationResults)
                        ));
                    }


                    header('Location:'.$ayar['panel_url'].'pages.php?page=hb_aktarilan_urunler');
                    exit();
                }else{
                    header('Location:'.$ayar['panel_url'].'pages.php?page=hb_aktarilan_urunler');
                    exit();
                }

            }

            if($_GET['status'] == 'hb_track_delete'  ) {
                $noID =  $_GET['id'];
                $silmeislem = $db->prepare("DELETE from hb_track WHERE id=:id");
                $sil = $silmeislem->execute(array(
                'id' => $noID
                ));
                if ($sil) {
                    $_SESSION['main_alert'] = 'success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=hb_aktarilan_urunler');
                    exit();
                }else {
                echo 'veritabanı hatası';
                }
            }

            if($_GET['status'] == 'hb_toplu_urun_gonder'  ) {
                if ($_POST) {

                    $aktarilacak = $db->prepare("select * from hb_urun_bilgi where hb_aktarim=:hb_aktarim and hb_izin=:hb_izin and hazir=:hazir");
                    $aktarilacak->execute(array(
                        'hb_aktarim' => '0',
                        'hb_izin' => '1',
                        'hazir' => '1',
                    ));

                    foreach ($aktarilacak as $item) {
                       $urun = $db->prepare("select baslik,barkod,urun_kod,fiyat,gorsel,stok,icerik,kdv_oran from urun where id=:id and durum=:durum ");
                       $urun->execute(array(
                           'id' => $item['urun_id'],
                           'durum' => '1'
                       ));
                       $urunrow = $urun->fetch(PDO::FETCH_ASSOC);

                       $ozellikListesi = $item['hb_ozellik'];

                        if($urunrow['barkod'] == !null ) {
                            $barkod = $urunrow['barkod'];
                        }else{
                            $barkod = $urunrow['urun_kod'];
                        }
                        if($urunrow['icerik'] == !null  ) {
                            $icerik = $urunrow['icerik'];
                        }else{
                            $icerik = $urunrow['baslik'];
                        }

                        if($urunrow['kdv_oran'] == !null ) {
                            $kdvoran = $urunrow['kdv_oran'];
                        }else{
                            $kdvoran = '18';
                        }



                        $oran = $_POST['ek_oran'];
                        $satisfiyat = $urunrow['fiyat'];

                        if($oran>'0'  ) {
                            $oranfiyat = kdvhesapla($satisfiyat,$oran);
                            $fiyat = $satisfiyat+$oranfiyat;
                        }else{
                            $fiyat = $satisfiyat;
                        }

                        $fiyat2= number_format((float)$fiyat, 2, '.', '');

                        $price  = $fiyat2;
                        $eski   = '.';
                        $yeni   = ',';
                        $price = str_replace($eski, $yeni, $price);


                        $jsonListData["$item[urun_id]"]=  array(
                            'categoryId' => $item['hb_kat_id'],
                            'merchant' => ''.$hbmerchant.'',
                            'attributes' => [
                                'merchantSku' => ''.$urunrow['urun_kod'].'',
                                'VaryantGroupID' => ''.$item['urun_id'].'',
                                'Barcode' => ''.$barkod.'',
                                'UrunAdi' => ''.$urunrow['baslik'].'',
                                'UrunAciklamasi' => ''.$icerik.'',
                                'price' => ''.$price.'',
                                'tax_vat_rate' => $kdvoran,
                                'stock' => ''.$urunrow['stok'].'',
                                'Image1' => ''.$ayar['site_url'].'images/product/'.$urunrow['gorsel'].''
                            ]
                        );

                        $cikar1 = $ozellikListesi;
                        $cikar1 = explode('|', $cikar1);

                        foreach ($cikar1 as $cik1){
                            $cikar2 = $cik1;
                            $cikar2 = explode('___', $cikar2);
                            foreach ($cikar2 as $cik2 => $c2){
                                if($c2 !='' && $cik2 == '0') {
                                    $jsonListData["$item[urun_id]"]["attributes"] = array_merge($jsonListData["$item[urun_id]"]["attributes"],
                                        array (
                                            ''.$cikar2[0].'' => ''.$cikar2[1].'',
                                        )
                                    );
                                }
                            }
                        }
                        
                        $guncelle = $db->prepare("UPDATE hb_urun_bilgi SET
                                hb_kod=:hb_kod,
                                hb_barkod=:hb_barkod,
                                hb_stok=:hb_stok,
                                hb_fiyat=:hb_fiyat
                         WHERE id={$item['id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'hb_kod' => $urunrow['urun_kod'],
                            'hb_barkod' => $urunrow['barkod'],
                            'hb_stok' => $urunrow['stok'],
                            'hb_fiyat' => $fiyat,
                        ));

                    }
                   $islem =  file_put_contents('assets/hb_product/hb_products.json',json_encode(array_values($jsonListData)));
                    if($islem  ) {


                        $url = 'https://mpop.hepsiburada.com/product/api/products/import';
                        //todo canlı moda geçtiğinde URL'yi düzenle

                        $file = __DIR__.'/../../../../assets/hb_product/hb_products.json';
                        $headers = [
                            'Content-Type: multipart/form-data',
                            'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                        ];

                        $fields = [
                            'file' => new CURLFile($file, 'application/json')
                        ];

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        $as = curl_exec($ch);
                        $as = json_decode($as,true);

                        if($as['success'] == '1' ) {
                            $gonderSonuc = $as['data']['trackingId'];
                            $timestamp = date('Y-m-d G:i:s');

                            /* track id ye göre ürünlerin durumları tek tek alınıyor */
                            $istek = 'https://mpop.hepsiburada.com/product/api/products/status/'.$gonderSonuc.'?page=0&size=10000&version=1';
                            //todo canlı moda geçtiğinde URL'yi düzenle

                            $service_url = $istek;
                            $curl = curl_init($service_url);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            $header = array(
                                'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.'')
                            );
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                            $curl_response = curl_exec($curl);

                            $trackResult = json_decode($curl_response);

                            foreach ($trackResult->data as $tf){
                                $productCode = $tf->merchantSku;
                                $productStatus = $tf->productStatus;
                                $UrunGetir = $db->prepare("select * from hb_urun_bilgi where hb_kod=:hb_kod ");
                                $UrunGetir->execute(array(
                                    'hb_kod' => $productCode
                                ));
                                //todo canlu moda geçtiğinde LOG kaydını ve veritabanına aktarımını kontrol et
                                $urunS = $UrunGetir->fetch(PDO::FETCH_ASSOC);
                                $guncelle = $db->prepare("UPDATE hb_urun_bilgi SET
                                     hb_durumu=:hb_durumu,
                                     hb_log=:hb_log,
                                     hb_tarih=:hb_tarih,
                                     hb_aktarim=:hb_aktarim
                                     WHERE id={$urunS['id']}      
                                    ");
                                $sonuc = $guncelle->execute(array(
                                    'hb_durumu' => $productStatus,
                                    'hb_log' => json_encode($tf->validationResults),
                                    'hb_tarih' => $timestamp,
                                    'hb_aktarim' => '1'
                                ));
                            }


                            /* Gönderilen ürün grubunun HB tracing Kodu */
                            $kaydet = $db->prepare("INSERT INTO hb_track SET
                                track=:track,
                                tarih=:tarih
                        ");
                            $sonuc = $kaydet->execute(array(
                                'track' => $gonderSonuc,
                                'tarih' => $timestamp
                            ));
                            /*  <========SON=========>>> Gönderilen ürün grubunun HB tracing Kodu SON */

                            header('Location:'.$ayar['panel_url'].'pages.php?page=hb_aktarilan_urunler');
                            exit();

                        }else{
                          die('Aktarım aşamasında hata oluştu.');
                        }








                    }else{
                        echo "Error";
                        exit();
                    }



                    //hepsi bitince aktarilanlar sayfasına yönlendir

                }

            }

            if($_GET['status'] == 'hb_ozellik'  ) {
                if ($_POST && isset($_POST['attAdd']) ) {
                        if($_POST['return'] == 'category'  ) {

                            $catSorgu = $db->prepare("select * from urun_cat where id=:id ");
                            $catSorgu->execute(array(
                                'id' => $_POST['cat_id']
                            ));
                            if($catSorgu->rowCount()<='0'  ) {
                                header('Location:'.$ayar['site_url'].'404');
                                exit();
                            }
                            $ozellik = $_POST['ozellik'];
                            foreach ($ozellik as $oz => $key){
                                if($key == !null  ) {
                                 $ozellikdb.=''.$oz.'___'.$key.'|';
                                }
                            }


                            $guncelle = $db->prepare("UPDATE urun_cat SET
                            hb_ozellik=:hb_ozellik
                     WHERE id={$_POST['cat_id']}      
                    ");
                            $sonuc = $guncelle->execute(array(
                                'hb_ozellik' => $ozellikdb
                            ));
                            if($sonuc){
                                $guncelle = $db->prepare("UPDATE hb_urun_bilgi SET
                                      hb_ozellik=:hb_ozellik,   
                                      hazir=:hazir
                                 WHERE hb_kat_id={$_POST['hb_kat_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'hb_ozellik' => $ozellikdb,
                                    'hazir' => '1'
                                ));
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_sync&catID='.$_POST['cat_id'].'');
                            }else{
                                echo 'Veritabanı Hatası';
                            }


                        }else{

                            $urunID = $_POST['urun_id'];
                            $ozellik = $_POST['ozellik'];
                            foreach ($ozellik as $oz => $key){
                                if($key == !null  ) {
                                    $ozellikdb.=''.$oz.'___'.$key.'|';
                                }
                            }
                            $guncelle = $db->prepare("UPDATE hb_urun_bilgi SET
                                      hb_ozellik=:hb_ozellik,   
                                      hazir=:hazir
                                 WHERE urun_id={$urunID}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'hb_ozellik' => $ozellikdb,
                                'hazir' => '1'
                            ));

                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_hb&productID='.$_POST['urun_id'].'');
                            /*  <========SON=========>>> ürün için SON */
                        }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'hb_settings'  ) {
                if($_POST && isset($_POST['settingSave'])  ) {

                    $guncelle = $db->prepare("UPDATE pazaryeri SET
                          hb_durum=:hb_durum,
                          hb_merchant=:hb_merchant
                   WHERE id='1'      
                  ");
                    $sonuc = $guncelle->execute(array(
                        'hb_durum' => $_POST['hb_durum'],
                        'hb_merchant' => $_POST['hb_merchant']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=hb_settings');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'hb_eslestir'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['cat_id'] && $_POST['return']) {
                    if($_POST['return'] == 'category' || $_POST['return'] == 'product'  ) {


                        if($_POST['return']=='product'  ) {
                            if($_POST['product_id'] == !null  ) {
                                $proID = $_POST['product_id'];
                            }else{
                                $proID = null;
                            }
                        }


                            if($_POST['return'] == 'category') {
                                $secilenKat = $_POST['select_kat_id'];
                                $fileCheck = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste1.json');
                                $json = json_decode($fileCheck);
                                $fileCheck2 = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste2.json');
                                $json2 = json_decode($fileCheck2);
                                $fileCheck3 = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste3.json');
                                $json3 = json_decode($fileCheck3);

                                foreach ($json->data as $a) {
                                    if($a->categoryId == ''.$secilenKat.''  ) {
                                        $i = 0;
                                        $len = count($a->paths);
                                        foreach ($a->paths as $p){
                                            $Katname .= $p;
                                            if ($i != $len - 1) {
                                                $Katname .= ' > ';
                                            }
                                            $i++;
                                        }
                                    }
                                }

                                foreach ($json2->data as $a) {
                                    if($a->categoryId == ''.$secilenKat.''  ) {
                                        $i = 0;
                                        $len = count($a->paths);
                                        foreach ($a->paths as $p){
                                            $Katname .= $p;
                                            if ($i != $len - 1) {
                                                $Katname .= ' > ';
                                            }
                                            $i++;
                                        }
                                    }
                                }

                                foreach ($json3->data as $a) {
                                    if($a->categoryId == ''.$secilenKat.''  ) {
                                        $i = 0;
                                        $len = count($a->paths);
                                        foreach ($a->paths as $p){
                                            $Katname .= $p;
                                            if ($i != $len - 1) {
                                                $Katname .= ' > ';
                                            }
                                            $i++;
                                        }
                                    }
                                }


                                $guncelle = $db->prepare("UPDATE urun_cat SET
                                         hb_sync=:hb_sync,
                                         hb_kat_isim=:hb_kat_isim,
                                         hb_ozellik=:hb_ozellik,
                                         hb_kat_id=:hb_kat_id
                                  WHERE id={$_POST['cat_id']}      
                                 ");
                                $sonuc = $guncelle->execute(array(
                                    'hb_sync' => '1',
                                    'hb_kat_isim' => $Katname,
                                    'hb_ozellik' => '0',
                                    'hb_kat_id' => $secilenKat
                                ));
                                
                                $urunForla = $db->prepare("select id,urun_kod,barkod from urun where iliskili_kat=:iliskili_kat and durum=:durum ");
                                $urunForla->execute(array(
                                    'iliskili_kat' => $_POST['cat_id'],
                                    'durum' => '1'
                                ));

                               /* Ürünleri Güncelle ve hb_urun_bilgiye */
                                foreach ($urunForla as $urunfor){
                                    $EnvSor = $db->prepare("select id from hb_envanter where urun_id=:urun_id ");
                                    $EnvSor->execute(array(
                                        'urun_id' => $urunfor['id'],
                                    ));
                                    if($EnvSor->rowCount()<='0'  ) {
                                        $varmi = $db->prepare("select * from hb_urun_bilgi where urun_id=:urun_id ");
                                        $varmi->execute(array(
                                            'urun_id' => $urunfor['id'],
                                        ));
                                        $varRow = $varmi->fetch(PDO::FETCH_ASSOC);
                                        if($varmi->rowCount()<='0'  ) {
                                            /* Bu ürün eklenmemiş insertle bilgi tablosuna */
                                            $kaydet = $db->prepare("INSERT INTO hb_urun_bilgi SET
                                                    urun_id=:urun_id,
                                                    hb_kat_id=:hb_kat_id,
                                                    hb_kat_isim=:hb_kat_isim,
                                                    hb_ozellik=:hb_ozellik,
                                                    hb_aktarim=:hb_aktarim,
                                                    hb_izin=:hb_izin,
                                                    hb_log=:hb_log,
                                                    hb_kod=:hb_kod,
                                                    hb_barkod=:hb_barkod,
                                                    hb_stok=:hb_stok,
                                                    hb_fiyat=:hb_fiyat,
                                                    hazir=:hazir
                                                    ");
                                            $sonuc = $kaydet->execute(array(
                                                'urun_id' => $urunfor['id'],
                                                'hb_kat_id' => $secilenKat,
                                                'hb_kat_isim' => $Katname,
                                                'hb_ozellik' => '0',
                                                'hb_aktarim' => '0',
                                                'hb_izin' => '1',
                                                'hb_log' => '0',
                                                'hb_kod' => $urunfor['urun_kod'],
                                                'hb_barkod' => $urunfor['barkod'],
                                                'hb_stok' => '0',
                                                'hb_fiyat' => '0',
                                                'hazir' => '0',
                                            ));
                                        }else{
                                            /* Bu ürün zaten var! Mevcut bilgilerini updatele */
                                            if($varRow['hb_aktarim'] !='1' ) {
                                                $guncelle = $db->prepare("UPDATE hb_urun_bilgi SET
                                                    hb_kat_id=:hb_kat_id,
                                                    hb_kat_isim=:hb_kat_isim,
                                                    hb_ozellik=:hb_ozellik,
                                                    hb_aktarim=:hb_aktarim,
                                                    hb_izin=:hb_izin,
                                                    hb_log=:hb_log,
                                                    hb_kod=:hb_kod,
                                                    hb_barkod=:hb_barkod,
                                                    hb_stok=:hb_stok,
                                                    hb_fiyat=:hb_fiyat,
                                                    hazir=:hazir
                                        WHERE id={$varRow['id']}
                                        ");
                                                $sonuc = $guncelle->execute(array(
                                                    'hb_kat_id' => $secilenKat,
                                                    'hb_kat_isim' => $Katname,
                                                    'hb_ozellik' => '0',
                                                    'hb_aktarim' => '0',
                                                    'hb_izin' => '1',
                                                    'hb_log' => '0',
                                                    'hb_kod' => $urunfor['urun_kod'],
                                                    'hb_barkod' => $urunfor['barkod'],
                                                    'hb_stok' => '0',
                                                    'hb_fiyat' => '0',
                                                    'hazir' => '0',
                                                ));
                                            }
                                            /*  <========SON=========>>> Bu ürün zaten var! Mevcut bilgilerini updatele SON */
                                        }
                                    }
                                }
                               /*  <========SON=========>>> Ürünleri Güncelle ve hb_urun_bilgiye SON */

                                /* Bu alanda seçili kategori ID sinin ozelliklerini file_put ile assets klasörüne yolla SON */
                                $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$secilenKat.'/attributes';
                                //todo canlı moda geçtiğinde URL'yi düzenle
                                $service_url = $istek;
                                $curl = curl_init($service_url);
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                $header = array(
                                    'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.''),
                                );
                                curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                $curl_response = curl_exec($curl);
                                $name = 'assets/hb_features/'.$secilenKat.'.json';
                                $gonder = file_put_contents($name,$curl_response);
                                /* Özellik Son */


                            }

                            if($_POST['return'] == 'product'  ) {

                                $EnvSor = $db->prepare("select id from hb_envanter where urun_id=:urun_id ");
                                $EnvSor->execute(array(
                                    'urun_id' => $proID,
                                ));


                                if($EnvSor->rowCount()<='0'  ) {
                                    $varmiki = $db->prepare("select * from hb_urun_bilgi where urun_id=:urun_id ");
                                    $varmiki->execute(array(
                                        'urun_id' => $proID,
                                    ));

                                    if($varmiki->rowCount()<='0'  ) {
                                        //bu ürün tabloda yok sıfırdan ekle

                                        $secilenKat = $_POST['select_kat_id'];
                                        $fileCheck = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste1.json');
                                        $json = json_decode($fileCheck);
                                        $fileCheck2 = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste2.json');
                                        $json2 = json_decode($fileCheck2);
                                        $fileCheck3 = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste3.json');
                                        $json3 = json_decode($fileCheck3);

                                        foreach ($json->data as $a) {
                                            if($a->categoryId == ''.$secilenKat.''  ) {
                                                $i = 0;
                                                $len = count($a->paths);
                                                foreach ($a->paths as $p){
                                                    $Katname .= $p;
                                                    if ($i != $len - 1) {
                                                        $Katname .= ' > ';
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                        foreach ($json2->data as $a) {
                                            if($a->categoryId == ''.$secilenKat.''  ) {
                                                $i = 0;
                                                $len = count($a->paths);
                                                foreach ($a->paths as $p){
                                                    $Katname .= $p;
                                                    if ($i != $len - 1) {
                                                        $Katname .= ' > ';
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                        foreach ($json3->data as $a) {
                                            if($a->categoryId == ''.$secilenKat.''  ) {
                                                $i = 0;
                                                $len = count($a->paths);
                                                foreach ($a->paths as $p){
                                                    $Katname .= $p;
                                                    if ($i != $len - 1) {
                                                        $Katname .= ' > ';
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }


                                        $urunForla = $db->prepare("select id,urun_kod,barkod from urun where id=:id  ");
                                        $urunForla->execute(array(
                                            'id' => $proID
                                        ));
                                        $urunfor = $urunForla->fetch(PDO::FETCH_ASSOC);


                                        $kaydet = $db->prepare("INSERT INTO hb_urun_bilgi SET
                                            urun_id=:urun_id,
                                            hb_kat_id=:hb_kat_id,
                                            hb_kat_isim=:hb_kat_isim,
                                            hb_ozellik=:hb_ozellik,
                                            hb_aktarim=:hb_aktarim,
                                            hb_izin=:hb_izin,
                                            hb_log=:hb_log,
                                            hb_kod=:hb_kod,
                                            hb_barkod=:hb_barkod,
                                            hb_stok=:hb_stok,
                                            hb_fiyat=:hb_fiyat,
                                            hazir=:hazir
                                            ");
                                        $sonuc = $kaydet->execute(array(
                                            'urun_id' => $proID,
                                            'hb_kat_id' => $secilenKat,
                                            'hb_kat_isim' => $Katname,
                                            'hb_ozellik' => '0',
                                            'hb_aktarim' => '0',
                                            'hb_izin' => '1',
                                            'hb_log' => '0',
                                            'hb_kod' => $urunfor['urun_kod'],
                                            'hb_barkod' => $urunfor['barkod'],
                                            'hb_stok' => '0',
                                            'hb_fiyat' => '0',
                                            'hazir' => '0',
                                        ));
                                        /* Bu alanda seçili kategori ID sinin ozelliklerini file_put ile assets klasörüne yolla SON */
                                        $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$secilenKat.'/attributes';
                                        //todo canlı moda geçtiğinde URL'yi düzenle
                                        $service_url = $istek;
                                        $curl = curl_init($service_url);
                                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                        $header = array(
                                            'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.''),
                                        );
                                        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                        $curl_response = curl_exec($curl);
                                        $name = 'assets/hb_features/'.$secilenKat.'.json';
                                        $gonder = file_put_contents($name,$curl_response);
                                        /* Özellik Son */

                                    }else{
                                        //bu ürün zaten var! Tekrar eşleştir butonu kullanılmıs
                                        $secilenKat = $_POST['select_kat_id'];
                                        $fileCheck = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste1.json');
                                        $json = json_decode($fileCheck);
                                        $fileCheck2 = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste2.json');
                                        $json2 = json_decode($fileCheck2);
                                        $fileCheck3 = file_get_contents(''.$ayar['panel_url'].'assets/hb_categories/liste3.json');
                                        $json3 = json_decode($fileCheck3);

                                        foreach ($json->data as $a) {
                                            if($a->categoryId == ''.$secilenKat.''  ) {
                                                $i = 0;
                                                $len = count($a->paths);
                                                foreach ($a->paths as $p){
                                                    $Katname .= $p;
                                                    if ($i != $len - 1) {
                                                        $Katname .= ' > ';
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                        foreach ($json2->data as $a) {
                                            if($a->categoryId == ''.$secilenKat.''  ) {
                                                $i = 0;
                                                $len = count($a->paths);
                                                foreach ($a->paths as $p){
                                                    $Katname .= $p;
                                                    if ($i != $len - 1) {
                                                        $Katname .= ' > ';
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                        foreach ($json3->data as $a) {
                                            if($a->categoryId == ''.$secilenKat.''  ) {
                                                $i = 0;
                                                $len = count($a->paths);
                                                foreach ($a->paths as $p){
                                                    $Katname .= $p;
                                                    if ($i != $len - 1) {
                                                        $Katname .= ' > ';
                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                        $urunForla = $db->prepare("select id,urun_kod,barkod from urun where id=:id  ");
                                        $urunForla->execute(array(
                                            'id' => $proID
                                        ));
                                        $urunfor = $urunForla->fetch(PDO::FETCH_ASSOC);


                                        $kaydet = $db->prepare("UPDATE hb_urun_bilgi SET
                                            urun_id=:urun_id,
                                            hb_kat_id=:hb_kat_id,
                                            hb_kat_isim=:hb_kat_isim,
                                            hb_ozellik=:hb_ozellik,
                                            hb_aktarim=:hb_aktarim,
                                            hb_izin=:hb_izin,
                                            hb_log=:hb_log,
                                            hb_kod=:hb_kod,
                                            hb_barkod=:hb_barkod,
                                            hb_stok=:hb_stok,
                                            hb_fiyat=:hb_fiyat,
                                            hazir=:hazir
                                            WHERE
                                            urun_id ={$proID}
                                            ");
                                        $sonuc = $kaydet->execute(array(
                                            'urun_id' => $proID,
                                            'hb_kat_id' => $secilenKat,
                                            'hb_kat_isim' => $Katname,
                                            'hb_ozellik' => '0',
                                            'hb_aktarim' => '0',
                                            'hb_izin' => '1',
                                            'hb_log' => '0',
                                            'hb_kod' => $urunfor['urun_kod'],
                                            'hb_barkod' => $urunfor['barkod'],
                                            'hb_stok' => '0',
                                            'hb_fiyat' => '0',
                                            'hazir' => '0',
                                        ));
                                        /* Bu alanda seçili kategori ID sinin ozelliklerini file_put ile assets klasörüne yolla SON */
                                        $istek = 'https://mpop.hepsiburada.com/product/api/categories/'.$secilenKat.'/attributes';
                                        //todo canlı moda geçtiğinde URL'yi düzenle
                                        $service_url = $istek;
                                        $curl = curl_init($service_url);
                                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                        $header = array(
                                            'Authorization: Basic '. base64_encode(''.$hbuser.':'.$hbpass.''),
                                        );
                                        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
                                        $curl_response = curl_exec($curl);
                                        $name = 'assets/hb_features/'.$secilenKat.'.json';
                                        $gonder = file_put_contents($name,$curl_response);
                                        /* Özellik Son */

                                    }
                                }



                            }

                            if($_POST['return'] == 'category'  ) {
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=hb_sync&catID='.$_POST['cat_id'].'');
                            }

                            if($_POST['return'] == 'product'  ) {
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_hb&productID='.$proID.'');
                            }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

        }else{
            header('Location:'.$ayar['site_url'].'404');
            exit();
        }
    }
}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}
