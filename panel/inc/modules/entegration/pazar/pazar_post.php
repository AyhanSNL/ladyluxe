<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'n11_settings' || $_GET['status'] == 'n11_toplurunguncelle' ||  $_GET['status'] == 'n11_ozellik' || $_GET['status'] == 'n11_topluislem_edit'  || $_GET['status'] == 'n11_topluislem'  || $_GET['status'] == 'n11_eslestir' ||  $_GET['status'] == 'n11_aktarim' ||  $_GET['status'] == 'n11_guncelle' ) {

            $timestamp = date('Y-m-d G:i:s');


            if($_GET['status'] == 'n11_topluislem_edit'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['process_id']) {
                    $guncelle = $db->prepare("UPDATE n11_islem SET
                          baslik=:baslik,
                          oran=:oran,
                          yerli=:yerli,
                          urun_durum=:urun_durum,
                          sablon=:sablon,
                          gun=:gun   
                     WHERE id={$_POST['process_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'oran' => $_POST['ek_oran'],
                        'yerli' => $_POST['yerli'],
                        'urun_durum' => $_POST['urun_durum'],
                        'sablon' => $_POST['sablon'],
                        'gun' => $_POST['kargo_sure']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
                        exit();
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'n11_topluislem'  ) {
                if ($_POST && isset($_POST['save'])) {

                    $kaydet = $db->prepare("INSERT INTO n11_islem SET
                          tarih=:tarih,  
                          durum=:durum,
                          baslik=:baslik,
                          kat_id=:kat_id,
                          islem=:islem,
                          oran=:oran,
                          yerli=:yerli,
                          urun_durum=:urun_durum,
                          sablon=:sablon,
                          gun=:gun
                    ");
                    $sonuc = $kaydet->execute(array(
                        'tarih' => $timestamp,
                        'durum' => '0',
                        'baslik' => $_POST['baslik'],
                        'kat_id' => $_POST['kat_id'],
                        'islem' => $_POST['islem'],
                        'oran' => $_POST['ek_oran'],
                        'yerli' => $_POST['yerli'],
                        'urun_durum' => $_POST['urun_durum'],
                        'sablon' => $_POST['sablon'],
                        'gun' => $_POST['kargo_sure']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process');
                        exit();
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'n11_eslestir'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['cat_id'] && $_POST['return']) {
                    if($_POST['return'] == 'category' || $_POST['return'] == 'product'  ) {
                        if($_POST['return']=='product'  ) {
                            if($_POST['product_id'] == !null  ) {
                                $proID = $_POST['product_id'];
                            }else{
                                $proID = null;
                            }
                        }
                        if($_POST['category_sub']  ) {
                            $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
                            $pazarYeri->execute();
                            $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
                            include "inc/modules/entegration/pazar/n11_api.php";
                            $katID = $_POST['category_sub'];
                            $attcek = $n11->ozellik($katID,1);
                            $contents = json_encode($attcek);
                            /* Kategori İsmi */
                            $subCats = $n11->GetParentCategory($katID);
                            $isim = $subCats->category->name;
                            $ustisim = $subCats->category->parentCategory->name;
                            $birUstID = $subCats->category->parentCategory->id;
                            $subCatsBirUst = $n11->GetParentCategory($birUstID);
                            $ikiisim = $subCatsBirUst->category->parentCategory->name;
                            $ikiID = $subCatsBirUst->category->parentCategory->id;
                            $enUst = $n11->GetParentCategory($ikiID);
                            $enUstisim = $enUst->category->parentCategory->name;

                            if($enUstisim == !null  ) {
                                $katIsim .= $enUstisim;
                                $katIsim .= " > ";
                            }
                            if($ikiisim == !null  ) {
                                $katIsim .= $ikiisim;
                                $katIsim .= " > ";
                            }
                            if($ustisim == !null  ) {
                                $katIsim .= $ustisim;
                                $katIsim .= " > ";
                            }
                            if($isim == !null  ) {
                                $katIsim .= $isim;
                            }
                            /*  <========SON=========>>> Kategori İsmi SON */



                            if($_POST['return'] == 'category') {
                                $guncelle = $db->prepare("UPDATE urun_cat SET
                                         n11_kat_id=:n11_kat_id,
                                         n11_ozellik=:n11_ozellik,
                                         n11_kat_isim=:n11_kat_isim
                                  WHERE id={$_POST['cat_id']}      
                                 ");
                                $sonuc = $guncelle->execute(array(
                                    'n11_kat_id' => $katID,
                                    'n11_ozellik' => '0',
                                    'n11_kat_isim' => $katIsim
                                ));

                                $guncelle = $db->prepare("UPDATE urun SET
                             n11_kat_id=:n11_kat_id,
                             n11_ozellik=:n11_ozellik,
                             n11_kuyruk=:n11_kuyruk,
                             n11_aktarim=:n11_aktarim,
                             n11_izin=:n11_izin,
                             n11_kat_isim=:n11_kat_isim
                                  WHERE iliskili_kat={$_POST['cat_id']}      
                                 ");
                                $sonuc = $guncelle->execute(array(
                                    'n11_kat_id' => $katID,
                                    'n11_ozellik' => '0',
                                    'n11_kuyruk' => '1',
                                    'n11_aktarim' => '0',
                                    'n11_izin' => '1',
                                    'n11_kat_isim' => $katIsim
                                ));
                            }


                            if($_POST['return'] == 'product'  ) {
                                $guncelle = $db->prepare("UPDATE urun SET
                                     n11_kat_id=:n11_kat_id,
                                     n11_ozellik=:n11_ozellik,
                                     n11_kuyruk=:n11_kuyruk,
                                     n11_aktarim=:n11_aktarim,
                                     n11_izin=:n11_izin,
                                     n11_kat_isim=:n11_kat_isim
                                  WHERE id={$proID}      
                                 ");
                                $sonuc = $guncelle->execute(array(
                                    'n11_kat_id' => $katID,
                                    'n11_ozellik' => '0',
                                    'n11_kuyruk' => '1',
                                    'n11_aktarim' => '0',
                                    'n11_izin' => '1',
                                    'n11_kat_isim' => $katIsim
                                ));
                            }

                            /* attributeleri php dosyası olarak kaydet */
                            $uploads_dir = '/../../../../assets/n11/cat/';
                            $dosyaName = ''.$katID.'';
                            $uzanti = ".php";

                            $dosya = fopen(__DIR__ . "$uploads_dir$dosyaName$uzanti", "w");
                            $yaz = fwrite($dosya, $contents);

                            if($_POST['return'] == 'category'  ) {
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=n11_sync&catID='.$_POST['cat_id'].'');
                            }
                            if($_POST['return'] == 'product'  ) {
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$proID.'');
                            }


                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=n11_sync&catID='.$_POST['cat_id'].'');
                            if($_POST['return'] == 'category'  ) {
                                $_SESSION['main_alert'] = 'altkatsec';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=n11_sync&catID='.$_POST['cat_id'].'');
                            }
                            if($_POST['return'] == 'product'  ) {
                                $_SESSION['main_alert'] = 'altkatsec';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$proID.'');
                            }
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
            if($_GET['status'] == 'n11_ozellik'  ) {
                if ($_POST && isset($_POST['attAdd']) && $_POST['cat_id']) {
                    if($_POST['return'] == 'category' || $_POST['return'] == 'product'   ) {
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
                            foreach ($ozellik as $oz){
                                if($oz == !null  ) {
                                $ozellikdb .=''.$oz.'|';
                                }
                            }
                            $guncelle = $db->prepare("UPDATE urun_cat SET
                            n11_ozellik=:n11_ozellik
                     WHERE id={$_POST['cat_id']}      
                    ");
                            $sonuc = $guncelle->execute(array(
                                'n11_ozellik' => $ozellikdb
                            ));
                            if($sonuc){
                                $guncelle = $db->prepare("UPDATE urun SET
                              n11_ozellik=:n11_ozellik   
                         WHERE iliskili_kat={$_POST['cat_id']}      
                        ");
                                $sonuc = $guncelle->execute(array(
                                    'n11_ozellik' => $ozellikdb
                                ));
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=n11_sync&catID='.$_POST['cat_id'].'');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            /* ürün için */
                            $catSorgu = $db->prepare("select * from urun_cat where id=:id ");
                            $catSorgu->execute(array(
                                'id' => $_POST['cat_id']
                            ));
                            if($catSorgu->rowCount()<='0'  ) {
                                header('Location:'.$ayar['site_url'].'404');
                                exit();
                            }
                            $ozellik = $_POST['ozellik'];
                            foreach ($ozellik as $oz){
                                if($oz == !null  ) {
                                    $ozellikdb .=''.$oz.'|';
                                }
                            }
                                $guncelle = $db->prepare("UPDATE urun SET
                                      n11_ozellik=:n11_ozellik   
                                 WHERE id={$_POST['product_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'n11_ozellik' => $ozellikdb
                                ));
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_POST['product_id'].'');
                            /*  <========SON=========>>> ürün için SON */
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
            if($_GET['status'] == 'n11_settings'  ) {
              if($_POST && isset($_POST['settingSave'])  ) {

                  $guncelle = $db->prepare("UPDATE pazaryeri SET
                          n11_durum=:n11_durum,
                          n11_api=:n11_api,
                          n11_sablon=:n11_sablon,
                          n11_aciklama=:n11_aciklama,
                          n11_secret=:n11_secret
                   WHERE id='1'      
                  ");
                  $sonuc = $guncelle->execute(array(
                      'n11_durum' => $_POST['n11_durum'],
                      'n11_api' => $_POST['n11_api'],
                      'n11_sablon' => $_POST['n11_sablon'],
                      'n11_aciklama' => $_POST['n11_aciklama'],
                      'n11_secret' => $_POST['n11_secret']
                  ));
                  if($sonuc){
                  $_SESSION['main_alert'] = 'success';
                  header('Location:'.$ayar['panel_url'].'pages.php?page=n11_settings');
                  }else{
                  echo 'Veritabanı Hatası';
                  }
              }else{
                  header('Location:'.$ayar['site_url'].'404');
                  exit();
              }
            }

            if($_GET['status'] == 'n11_guncelle'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['product_id']) {
                    $urun = $db->prepare("select * from urun where id=:id ");
                    $urun->execute(array(
                        'id' => $_POST['product_id']
                    ));
                    if ($urun->rowCount() > '0') {
                        $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
                        $pazarYeri->execute();
                        $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
                        include "inc/modules/entegration/pazar/n11_api.php";
                        $row = $urun->fetch(PDO::FETCH_ASSOC);
                        $n11Urun = $db->prepare("select * from n11_urun where urun_id=:urun_id ");
                        $n11Urun->execute(array(
                            'urun_id' => $row['id']
                        ));
                        $n11Row = $n11Urun->fetch(PDO::FETCH_ASSOC);
                        $fiyatupd = $_POST['fiyat_upd'];
                        $oran = $_POST['ek_oran'];
                        $descupd = $_POST['desc_upd'];
                        $stokupd = $_POST['stok_upd'];
                        $fotoupd = $_POST['foto_upd'];
                        $satisfiyat = $row['fiyat'];
                        if($fiyatupd == '1'  ) {
                            if($oran>'0'  ) {
                                $oranfiyat = kdvhesapla($satisfiyat,$oran);
                                $fiyat = $satisfiyat+$oranfiyat;
                            }else{
                                $fiyat = $satisfiyat;
                            }
                        }else{
                            $fiyat = $n11Row['n11_fiyat'];
                        }
                        if($descupd == '1'  ) {
                            $icerik  = $row['icerik'];
                            $eski   = '../i/';
                            $yeni   = ''.$ayar['site_url'].'i/';
                            $icerik = str_replace($eski, $yeni, $icerik);
                        }else{
                            $icerik = $n11Row['n11_desc'];
                        }
                        if($stokupd == '1'  ) {
                            $stok = $row['stok'];
                        }else{
                            $stok = $n11Row['n11_stok'];
                        }
                        if($fotoupd == '1'  ) {
                            $foto = ''.$ayar['site_url'].'images/product/'.$row['gorsel'].'';
                        }else{
                            $foto = ''.$n11Row['n11_foto'].'';
                        }
                        $updateProduct = $n11->updateProductBasic($row['n11_kod'],$fiyat,''.$foto.'',''.$icerik.'',$stok);
                        $durum = $updateProduct->result->status;
                        if($durum == 'success'  ) {
                            $guncelle = $db->prepare("UPDATE urun SET
                                    n11_tarih=:n11_tarih,
                                    n11_aktarim=:n11_aktarim,
                                    n11_log=:n11_log                                    
                             WHERE id={$_POST['product_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'n11_tarih' => $timestamp,
                                'n11_aktarim' => '1',
                                'n11_log' => '0'
                            ));
                            $guncelle = $db->prepare("UPDATE n11_urun SET
                            n11_stok=:n11_stok,
                            n11_foto=:n11_foto,
                            n11_desc=:n11_desc,
                            n11_fiyat=:n11_fiyat   
                             WHERE urun_id={$_POST['product_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'n11_stok' => $stok,
                                'n11_foto' => $foto,
                                'n11_desc' => $icerik,
                                'n11_fiyat' => $fiyat
                            ));
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_POST['product_id'].'');
                        }else{
                            $_SESSION['main_alert'] = 'n11hata';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_POST['product_id'].'');
                            $guncelle = $db->prepare("UPDATE urun SET
                                    n11_tarih=:n11_tarih,
                                    n11_log=:n11_log                                    
                             WHERE id={$_POST['product_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'n11_tarih' => $timestamp,
                                'n11_log' => json_encode($updateProduct)
                            ));
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

            if($_GET['status'] == 'n11_aktarim'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['product_id']) {
                    $urun = $db->prepare("select * from urun where id=:id ");
                    $urun->execute(array(
                        'id' => $_POST['product_id']
                    ));
                    if($urun->rowCount()>'0'  ) {
                        $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
                        $pazarYeri->execute();
                        $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
                        include "inc/modules/entegration/pazar/n11_api.php";
                        $row = $urun->fetch(PDO::FETCH_ASSOC);

                        $oran = $_POST['ek_oran'];
                        $sablon = $_POST['sablon'];
                        $gun = $_POST['kargo_sure'];
                        $yerli = $_POST['yerli'];
                        $durumu = $_POST['durumu'];

                        if($yerli == '1'  ) {
                         $yerliDurum = true;
                        }else{
                            $yerliDurum = false;
                        }

                        $satisfiyat = $row['fiyat'];

                        if($oran>'0'  ) {
                            $oranfiyat = kdvhesapla($satisfiyat,$oran);
                            $fiyat = $satisfiyat+$oranfiyat;
                        }else{
                            $fiyat = $satisfiyat;
                        }



                        $veri = $row['n11_ozellik'];

                        $verim = $veri;
                        $verim = explode('|', $verim);

                        foreach ($verim as $v){
                            $v2 = $v;
                            $v2 = explode('_', $v2);
                            foreach ($v2 as $a =>$key){
                                if($key !='' && $a == '0') {
                                    $siparisler[]=
                                        ['name' => ''.$v2[0].'','value' => ''.$v2[1].''];
                                }
                            }
                        }

                        $icerik_cek  = $row['icerik'];
                        $eski   = '../i/';
                        $yeni   = ''.$ayar['site_url'].'i/';
                        $icerik_cek = str_replace($eski, $yeni, $icerik_cek);

                        $icerik = trim(strip_tags($icerik_cek));

                        $saveProduct = $n11->SaveProduct(
                            [
                                'productSellerCode' => ''.$row['urun_kod'].'',
                                'title' => ''.$row['baslik'].'',
                                'subtitle' => ''.$row['baslik'].'',
                                'description' => ''.$icerik.'',
                                'attributes' =>
                                    [
                                        'attribute' =>
                                            $siparisler


                                    ],
                                'category' =>
                                    [
                                        'id' => $row['n11_kat_id']
                                    ],
                                'price' => $fiyat,
                                'currencyType' => 'TL',
                                'images' =>
                                    [
                                        'image' =>
                                            [
                                                'url' => ''.$ayar['site_url'].'images/product/'.$row['gorsel'].'',
                                                'order' => 1
                                            ]
                                    ],
                                'saleStartDate' => '',
                                'saleEndDate' => '',
                                'productionDate' => '',
                                'expirationDate' => '',
                                'productCondition' => ''.$durumu.'',
                                'domestic' => $yerliDurum,
                                'preparingDay' => ''.$gun.'',
                                'discount' => '',
                                'shipmentTemplate' => ''.$sablon.'',
                                'groupAttribute' => null,
                                'groupItemCode' => null,
                                'unitInfo' => '',
                                'maxPurchaseQuantity' => $row['stok'],
                                'itemName' => null,
                                'stockItems' =>
                                    [
                                        'stockItem' =>
                                            [
                                                'n11CatalogId' => 0,
                                                'quantity' => $row['stok'],
                                                'sellerStockCode' => ''.$row['urun_kod'].'',
                                                'attributes' =>
                                                    [
                                                        'attribute' => []
                                                    ],
                                                'optionPrice' => $fiyat
                                            ]
                                    ]
                            ]
                        );
                        $durum = $saveProduct->result->status;
                        if($durum == 'success'  ) {
                            $guncelle = $db->prepare("UPDATE urun SET
                                    n11_tarih=:n11_tarih,
                                    n11_aktarim=:n11_aktarim,
                                    n11_kod=:n11_kod,
                                    n11_log=:n11_log                                    
                             WHERE id={$_POST['product_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'n11_tarih' => $timestamp,
                                'n11_aktarim' => '1',
                                'n11_kod' => $row['urun_kod'],
                                'n11_log' => '0'
                            ));
                            $kaydet = $db->prepare("INSERT INTO n11_urun SET
                            urun_id=:urun_id,
                            n11_stok=:n11_stok,
                            n11_foto=:n11_foto,
                            n11_desc=:n11_desc,
                            n11_fiyat=:n11_fiyat
                            ");
                            $sonuc = $kaydet->execute(array(
                                'urun_id' => $row['id'],
                                'n11_stok' => $row['stok'],
                                'n11_foto' => ''.$ayar['site_url'].'images/product/'.$row['gorsel'].'',
                                'n11_desc' => $icerik,
                                'n11_fiyat' => $fiyat
                            ));
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_POST['product_id'].'');
                        }else{
                            $_SESSION['main_alert'] = 'n11hata';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration&productID='.$_POST['product_id'].'');
                            $guncelle = $db->prepare("UPDATE urun SET
                                    n11_tarih=:n11_tarih,
                                    n11_log=:n11_log                                    
                             WHERE id={$_POST['product_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'n11_tarih' => $timestamp,
                                'n11_log' => json_encode($saveProduct)
                            ));
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

            if($_GET['status'] == 'n11_toplurunguncelle'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['process_id']) {
                    $processSorgfu = $db->prepare("select * from n11_islem where id=:id ");
                    $processSorgfu->execute(array(
                        'id' => $_POST['process_id']
                    ));
                    if($processSorgfu->rowCount()> '0' ) {
                        $islemRow = $processSorgfu->fetch(PDO::FETCH_ASSOC);
                        $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
                        $pazarYeri->execute();
                        $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
                        include "inc/modules/entegration/pazar/n11_api.php";
                        $katID = $islemRow['kat_id'];
                        $ekTur = $_POST['ek_tur'];
                        $fiyatupd = $_POST['fiyat_upd'];
                        $oran = $_POST['ek_oran'];
                        $descupd = $_POST['desc_upd'];
                        $stokupd = $_POST['stok_upd'];
                        $fotoupd = $_POST['foto_upd'];
                        $foreachSorgu = $db->prepare("select * from urun where n11_aktarim = '1' and n11_kod >'0'  and iliskili_kat='$katID'");
                        $foreachSorgu->execute();
                        foreach ($foreachSorgu as $row){
                            $satisfiyat = $row['fiyat'];
                            $n11Urun = $db->prepare("select * from n11_urun where urun_id=:urun_id ");
                            $n11Urun->execute(array(
                                'urun_id' => $row['id']
                            ));
                            $n11Row = $n11Urun->fetch(PDO::FETCH_ASSOC);
                            if($_POST['fiyat_upd'] == '1'  ) {
                                if($ekTur == '1'  ) {
                                    $fiyat = $satisfiyat;
                                }
                                if($ekTur == '2'  ) {
                                    if($oran>'0'  ) {
                                        $oranfiyat = kdvhesapla($satisfiyat,$oran);
                                        $fiyat = $satisfiyat+$oranfiyat;
                                    }else{
                                        $fiyat = $satisfiyat;
                                    }
                                }
                                if($ekTur == '3'  ) {
                                    if($oran>'0'  ) {
                                        $oranfiyat = kdvhesapla($satisfiyat,$oran);
                                        $fiyat = $satisfiyat-$oranfiyat;
                                    }else{
                                        $fiyat = $satisfiyat;
                                    }
                                }
                            }else{
                              $fiyat = $n11Row['n11_fiyat'];
                            }
                            if($descupd == '1'  ) {
                                $icerik  = $row['icerik'];
                                $eski   = '../i/';
                                $yeni   = ''.$ayar['site_url'].'i/';
                                $icerik = str_replace($eski, $yeni, $icerik);
                            }else{
                                $icerik = $n11Row['n11_desc'];
                            }
                            if($stokupd == '1'  ) {
                                $stok = $row['stok'];
                            }else{
                                $stok = $n11Row['n11_stok'];
                            }
                            if($fotoupd == '1'  ) {
                                $foto = ''.$ayar['site_url'].'images/product/'.$row['gorsel'].'';
                            }else{
                                $foto = ''.$n11Row['n11_foto'].'';
                            }
                            $updateProduct = $n11->updateProductBasic($row['n11_kod'],$fiyat,''.$foto.'',''.$icerik.'',$stok);
                                $guncelle = $db->prepare("UPDATE urun SET
                                    n11_tarih=:n11_tarih,
                                    n11_aktarim=:n11_aktarim,
                                    n11_log=:n11_log                                    
                             WHERE id={$row['id']}      
                            ");
                                $sonuc = $guncelle->execute(array(
                                    'n11_tarih' => $timestamp,
                                    'n11_aktarim' => '1',
                                    'n11_log' => '0'
                                ));
                                $guncelle = $db->prepare("UPDATE n11_urun SET
                            n11_stok=:n11_stok,
                            n11_foto=:n11_foto,
                            n11_desc=:n11_desc,
                            n11_fiyat=:n11_fiyat   
                             WHERE urun_id={$row['id']}      
                            ");
                                $sonuc = $guncelle->execute(array(
                                    'n11_stok' => $stok,
                                    'n11_foto' => $foto,
                                    'n11_desc' => $icerik,
                                    'n11_fiyat' => $fiyat
                                ));

                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process_products&process_id='.$_POST['process_id'].'');
                        exit();
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=n11_process_products&process_id='.$_POST['process_id'].'');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }



}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}