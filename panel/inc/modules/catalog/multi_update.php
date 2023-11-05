<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    $secure1 = trim(strip_tags($_POST['updateStatusPersonality']));
    $secure2 = trim(strip_tags($_POST['updateStatus']));
    $selected = trim(strip_tags($_POST['secenek']));

    if($secure1 == 'true' && $secure2 == 'success'  ) {
        if($selected  ) {
            if($selected == 'price_plus' || $selected == 'stock_code' || $selected == 'price_minus' || $selected == 'price_plus_percent' || $selected == 'price_minus_percent' || $selected == 'stock_plus' ||$selected=='stock_minus' || $selected == 'cargo' || $selected == 'status_choose' || $selected == 'kdv') {

                /* İnputlar */
                $searchInput = trim(strip_tags($_POST['search_input']));
                $statusInput = trim(strip_tags($_POST['status_input']));
                $featureInput = trim(strip_tags($_POST['feature_input']));
                $date1Input = trim(strip_tags($_POST['date_1_input']));
                $date2Input = trim(strip_tags($_POST['date_2_input']));
                $minInput = trim(strip_tags($_POST['min_input']));
                $maxInput = trim(strip_tags($_POST['max_input']));
                $catInput = trim(strip_tags($_POST['category_input']));
                $brandInput = trim(strip_tags($_POST['brand_input']));
                /*  <========SON=========>>> İnputlar SON */


                $searchGet =$searchInput;
                if($searchGet == !null ) {
                    $search = "where (baslik like '%$searchGet%' or seo_baslik like '%$searchGet%' or spot like '%$searchGet%' or icerik like '%$searchGet%' or tags like '%$searchGet%' or meta_desc like '%$searchGet%' or urun_kod like '%$searchGet%' or seo_url like '%$searchGet%') ";
                }else{
                    $search = "where (baslik like '%$searchGet%' or seo_baslik like '%$searchGet%' or spot like '%$searchGet%' or icerik like '%$searchGet%' or tags like '%$searchGet%' or meta_desc like '%$searchGet%' or urun_kod like '%$searchGet%' or seo_url like '%$searchGet%') ";
                }


                if($statusInput == '0' || $statusInput == null  ||$statusInput == '1' || $statusInput == '2' ||$statusInput == '3' || $statusInput == '4' ||$statusInput == '5' || $statusInput == '6' || $statusInput == '7' || $statusInput == '8'  ) {
                    if($statusInput == '0'  ) {
                        $productStatusGet = "and durum='0'";
                    }
                    if($statusInput == '1'  ) {
                        $productStatusGet = "and durum='1'";
                    }
                    if($statusInput == '2'  ) {
                        $productStatusGet = "and gorunmez='1'";
                    }
                    if($statusInput == '3'  ) {
                        $productStatusGet = "and siparis_islem='0'";
                    }
                    if($statusInput == '4'  ) {
                        $productStatusGet = "and siparis_islem!='0'";
                    }
                    if($statusInput == '5'  ) {
                        $productStatusGet = "and fiyat_goster='0'";
                    }
                    if($statusInput == '6'  ) {
                        $productStatusGet = "and fiyat_goster='1'";
                    }
                    if($statusInput == '7'  ) {
                        $productStatusGet = "and fiyat_goster='2'";
                    }
                    if($statusInput == '8'  ) {
                        $productStatusGet = "and fiyat_goster='3'";
                    }
                }else{
                    $productStatusGet = null;
                }

                    if( $featureInput == null  ||$featureInput == '1' || $featureInput == '2' ||$featureInput == '3' || $featureInput == '4' ||$featureInput == '5' || $featureInput == '6'  ) {

                        if ($featureInput == '1') {
                            $featureGet = "and indirim='1'";
                        }
                        if ($featureInput == '2') {
                            $featureGet = "and firsat='1'";
                        }
                        if ($featureInput == '3') {
                            $featureGet = "and hizli_kargo='1'";
                        }
                        if ($featureInput == '4') {
                            $featureGet = "and editor_secim ='1'";
                        }
                        if ($featureInput == '5') {
                            $featureGet = "and yeni='1'";
                        }
                        if ($featureInput == '6') {
                            $featureGet = "and taksit='1'";
                        }
                    }else{
                        $featureGet = null;
                    }

                if($catInput == !null  ) {
                    $categoryIDCome = $catInput;
                    $categoryGet = "and (kat_id like '%$categoryIDCome,%')";
                }

                if($brandInput == !null ) {
                    $brandSecureGet = $brandInput;
                    $brandGet = "and marka='$brandSecureGet'";
                }

                if($date1Input == !null ) {
                    $dateGet = "and sade_tarih >='$date1Input' ";
                }else{
                    $dateGet = null;
                }

                if($date2Input == !null) {
                    $dateEndGet = "and sade_tarih <='$date2Input'  ";
                }else{
                    $dateEndGet = null;
                }

                if($minInput == !null ) {
                    $minTutarSecure = $minInput;
                    $minTutarGet = "and (fiyat >='$minTutarSecure')  ";
                }else{
                    $minTutarGet = null;
                }
                if($maxInput == !null ) {
                    $maxTutarSecure = $maxInput;
                    $maxTutarGet = "and (fiyat <='$maxTutarSecure')  ";
                }else{
                    $maxTutarGet = null;
                }

                $uruNSorgu = $db->prepare("select id from urun $search $productStatusGet $featureGet $categoryGet $brandGet $dateGet $dateEndGet $minTutarGet $maxTutarGet");
                $uruNSorgu->execute();

                /* Otomatik Stok Kodu Üret */
                if($selected == 'stock_code'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        function get_random_string($length = 7, $characters = "ABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789")
                        {
                            $return = "";
                            $num_characters = strlen($characters) - 1;
                            while (strlen($return) < $length) {
                                $return .= $characters[mt_rand(0, $num_characters)];
                            }
                            return $return;
                        }
                        foreach ($uruNSorgu as $row){
                            $stokKodu = get_random_string();
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);
                            $guncelle = $db->prepare("UPDATE urun SET
                                    urun_kod=:urun_kod
                             WHERE id={$inRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'urun_kod' => $stokKodu
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
                /*  <========SON=========>>> Otomatik Stok Kodu Üret SON */

                /* Fiyat artırma işlemi */
                    if($selected == 'price_plus'  ) {
                        if($uruNSorgu->rowCount()>'0'  ) {
                            foreach ($uruNSorgu as $row){
                                $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                                $urunSorguSql->execute(array(
                                    'id' => $row['id']
                                ));
                                $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);
                                if($_POST['plus_price_value'] == !null  ) {
                                    $gelenFiyat = trim(strip_tags($_POST['plus_price_value']));
                                }else{
                                    $gelenFiyat = '0';
                                }
                                if($_POST['ozel_plus_price_value'] == !null  ) {
                                    $gelenTip2Fiyat = trim(strip_tags($_POST['ozel_plus_price_value']));
                                }else{
                                    $gelenTip2Fiyat = '0';
                                }
                                $yeniFiyat = $inRow['fiyat']+$gelenFiyat;

                                if($inRow['fiyat_tip2'] >'0' ) {
                                    $yeniFiyatTip2 = $inRow['fiyat_tip2']+$gelenTip2Fiyat;
                                }else{
                                    $yeniFiyatTip2 = '0';
                                }
                                $guncelle = $db->prepare("UPDATE urun SET
                                    fiyat=:fiyat,
                                    fiyat_tip2=:fiyat_tip2
                             WHERE id={$inRow['id']}      
                            ");
                                $sonuc = $guncelle->execute(array(
                                    'fiyat' => $yeniFiyat,
                                    'fiyat_tip2' => $yeniFiyatTip2
                                ));
                            }
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }
                /*  <========SON=========>>> Fiyat artırma işlemi SON */

                /* Fiyat Azaltma */
                if($selected == 'price_minus'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        foreach ($uruNSorgu as $row){
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);

                            if($_POST['minus_price_value'] == !null  ) {
                                $gelenFiyat = trim(strip_tags($_POST['minus_price_value']));
                            }else{
                                $gelenFiyat = '0';
                            }
                            if($_POST['ozel_minus_price_value'] == !null  ) {
                                $gelenTip2Fiyat = trim(strip_tags($_POST['ozel_minus_price_value']));
                            }else{
                                $gelenTip2Fiyat = '0';
                            }

                            if($inRow['fiyat'] > $gelenFiyat  ) {
                                $yeniFiyat = $inRow['fiyat']-$gelenFiyat;
                            }else{
                                $yeniFiyat = $inRow['fiyat'];
                            }

                            if($inRow['fiyat_tip2'] >'0' ) {
                                if($inRow['fiyat_tip2'] > $gelenTip2Fiyat ) {
                                    $yeniFiyatTip2 = $inRow['fiyat_tip2']-$gelenTip2Fiyat;
                                }else{
                                    $yeniFiyatTip2 = $inRow['fiyat_tip2'];
                                }
                            }else{
                                $yeniFiyatTip2 = '0';
                            }

                            $guncelle = $db->prepare("UPDATE urun SET
                                    fiyat=:fiyat,
                                    fiyat_tip2=:fiyat_tip2,
                                    indirim=:indirim
                             WHERE id={$inRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'fiyat' => $yeniFiyat,
                                'fiyat_tip2' => $yeniFiyatTip2,
                                'indirim' => $_POST['indirim'],
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
                /*  <========SON=========>>> Fiyat Azaltma SON */

                /* Oran olarak artır */
                if($selected == 'price_plus_percent'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        foreach ($uruNSorgu as $row){
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);
                            if($_POST['plus_price_percent'] == !null  ) {
                                $gelenOran = trim(strip_tags($_POST['plus_price_percent']));
                                $oranHesap = ($inRow['fiyat']*$gelenOran)/100;

                                if($inRow['fiyat'] >= $oranHesap ) {
                                    $yeniFiyat = $inRow['fiyat']+$oranHesap;
                                }else{
                                    $yeniFiyat = $inRow['fiyat'];
                                }
                            }else{
                                $yeniFiyat = $inRow['fiyat'];
                            }
                            if($_POST['ozel_plus_price_percent'] == !null  ) {
                                if($inRow['fiyat_tip2'] >'0' ) {
                                    $gelenOranTip2 = trim(strip_tags($_POST['ozel_plus_price_percent']));
                                    $oranHesapTip2 = ($inRow['fiyat_tip2']*$gelenOranTip2)/100;

                                    if($inRow['fiyat_tip2'] >= $oranHesapTip2 ) {
                                        $yeniFiyatTip2 = $inRow['fiyat_tip2']+$oranHesapTip2;
                                    }else{
                                        $yeniFiyatTip2 = $inRow['fiyat_tip2'];
                                    }
                                }else{
                                    $yeniFiyatTip2 = $inRow['fiyat_tip2'];
                                }
                            }else{
                                $yeniFiyatTip2 = $inRow['fiyat_tip2'];
                            }

                            $guncelle = $db->prepare("UPDATE urun SET
                                    fiyat=:fiyat,
                                    fiyat_tip2=:fiyat_tip2
                             WHERE id={$inRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'fiyat' => $yeniFiyat,
                                'fiyat_tip2' => $yeniFiyatTip2
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
                /*  <========SON=========>>> Oran olarak artır SON */

                /* Oran Olarak Azalt */
                if($selected == 'price_minus_percent'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        foreach ($uruNSorgu as $row){
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);
                            if($_POST['minus_price_percent'] == !null  ) {
                                $gelenOran = trim(strip_tags($_POST['minus_price_percent']));
                                $oranHesap = ($inRow['fiyat']*$gelenOran)/100;

                                if($inRow['fiyat'] >= $oranHesap ) {
                                    $yeniFiyat = $inRow['fiyat']-$oranHesap;
                                }else{
                                    $yeniFiyat = $inRow['fiyat'];
                                }
                            }else{
                                $yeniFiyat = $inRow['fiyat'];
                            }
                            if($_POST['ozel_minus_price_percent'] == !null  ) {
                                if($inRow['fiyat_tip2'] >'0' ) {
                                    $gelenOranTip2 = trim(strip_tags($_POST['ozel_minus_price_percent']));
                                    $oranHesapTip2 = ($inRow['fiyat_tip2']*$gelenOranTip2)/100;

                                    if($inRow['fiyat_tip2'] >= $oranHesapTip2 ) {
                                        $yeniFiyatTip2 = $inRow['fiyat_tip2']-$oranHesapTip2;
                                    }else{
                                        $yeniFiyatTip2 = $inRow['fiyat_tip2'];
                                    }
                                }else{
                                    $yeniFiyatTip2 = $inRow['fiyat_tip2'];
                                }
                            }else{
                                $yeniFiyatTip2 = $inRow['fiyat_tip2'];
                            }

                            $guncelle = $db->prepare("UPDATE urun SET
                                    fiyat=:fiyat,
                                    fiyat_tip2=:fiyat_tip2,
                                    indirim=:indirim
                             WHERE id={$inRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'fiyat' => $yeniFiyat,
                                'fiyat_tip2' => $yeniFiyatTip2,
                                'indirim' => $_POST['indirim']
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
                /*  <========SON=========>>> Oran Olarak Azalt SON */

             /* Stok artır */
                if($selected == 'stock_plus'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        foreach ($uruNSorgu as $row){
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);
                            if($_POST['plus_stock_value']  == !null ) {
                                $gelenStok = trim(strip_tags($_POST['plus_stock_value']));
                                $yeniStok = $inRow['stok']+$gelenStok;
                            }else{
                                $yeniStok = $inRow['stok'];
                            }
                            $guncelle = $db->prepare("UPDATE urun SET
                                    stok=:stok
                             WHERE id={$inRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'stok' => $yeniStok
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
             /*  <========SON=========>>> Stok artır SON */

                /* Stok Azalt */
                if($selected == 'stock_minus'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        foreach ($uruNSorgu as $row){
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);
                            if($_POST['minus_stock_value']  == !null ) {
                                $gelenStok = trim(strip_tags($_POST['minus_stock_value']));
                                if($inRow['stok'] >= $gelenStok  ) {
                                    $yeniStok = $inRow['stok']-$gelenStok;
                                }else{
                                    $yeniStok = $inRow['stok'];
                                }
                            }else{
                                $yeniStok = $inRow['stok'];
                            }
                            $guncelle = $db->prepare("UPDATE urun SET
                                    stok=:stok
                             WHERE id={$inRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'stok' => $yeniStok
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
                /*  <========SON=========>>> Stok Azalt SON */

                /* kargo Ayarı */
                if($selected == 'cargo'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        foreach ($uruNSorgu as $row){
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);

                            $gelenKargoDurum = trim(strip_tags($_POST['cargo_value']));
                            $gelenKargoTip = trim(strip_tags($_POST['kargo_tipi']));
                            $gelenUcret = trim(strip_tags($_POST['kargo_ucret']));
                            $kargoSure = trim(strip_tags($_POST['kargo_sure']));
                            $kargoHizli = trim(strip_tags($_POST['hizli_kargo']));

                            if($gelenKargoDurum == '1' ) {
                             if($gelenUcret == !null  ) {
                              $yeniucret = $gelenUcret;
                             }else{
                                 $gelenKargoDurum = '0';
                             }
                            }

                            $guncelle = $db->prepare("UPDATE urun SET
                                    kargo=:kargo,
                                    kargo_tipi=:kargo_tipi,
                                    kargo_ucret=:kargo_ucret,
                                    hizli_kargo=:hizli_kargo,
                                    kargo_sure=:kargo_sure
                             WHERE id={$inRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'kargo' =>$gelenKargoDurum,
                                'kargo_tipi' => $gelenKargoTip,
                                'kargo_ucret' => $yeniucret,
                                'hizli_kargo' => $kargoHizli,
                                'kargo_sure' => $kargoSure
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
                /*  <========SON=========>>> kargo Ayarı SON */

                /* KDV */
                if($selected == 'kdv'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        foreach ($uruNSorgu as $row){
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);

                            $gelenKDVDurum = trim(strip_tags($_POST['kdv_value']));
                            $kdvOrani = trim(strip_tags($_POST['kdv_percent']));
                            
                            $guncelle = $db->prepare("UPDATE urun SET
                                    kdv=:kdv,
                                    kdv_oran=:kdv_oran
                             WHERE id={$inRow['id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'kdv' => $gelenKDVDurum,
                                'kdv_oran' => $kdvOrani,
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
                /*  <========SON=========>>> KDV SON */

                /* Durum Güncellemesi */
                if($selected == 'status_choose'  ) {
                    if($uruNSorgu->rowCount()>'0'  ) {
                        foreach ($uruNSorgu as $row){
                            $urunSorguSql = $db->prepare("select * from urun where id=:id ");
                            $urunSorguSql->execute(array(
                                'id' => $row['id']
                            ));
                            $inRow = $urunSorguSql->fetch(PDO::FETCH_ASSOC);

                            $durumValue = trim(strip_tags($_POST['durum_value']));

                          if( $durumValue == '1' || $durumValue == '2' || $durumValue == '3' || $durumValue=='4' || $durumValue =='5' || $durumValue=='6' || $durumValue=='7' || $durumValue=='8') {
                              if($durumValue == '1'  ) {
                                  $guncelle = $db->prepare("UPDATE urun SET
                                    durum=:durum
                                     WHERE id={$inRow['id']}      
                                    ");
                                  $sonuc = $guncelle->execute(array(
                                      'durum' => '0'
                                  ));
                              }
                              if($durumValue == '2'  ) {
                                  $guncelle = $db->prepare("UPDATE urun SET
                                    gorunmez=:gorunmez
                                     WHERE id={$inRow['id']}      
                                    ");
                                  $sonuc = $guncelle->execute(array(
                                      'gorunmez' => '1'
                                  ));
                              }
                              if($durumValue == '3'  ) {
                                  $guncelle = $db->prepare("UPDATE urun SET
                                    fiyat_goster=:fiyat_goster
                                     WHERE id={$inRow['id']}      
                                    ");
                                  $sonuc = $guncelle->execute(array(
                                      'fiyat_goster' => '0'
                                  ));
                              }
                              if($durumValue == '4'  ) {
                                  $guncelle = $db->prepare("UPDATE urun SET
                                    fiyat_goster=:fiyat_goster
                                     WHERE id={$inRow['id']}      
                                    ");
                                  $sonuc = $guncelle->execute(array(
                                      'fiyat_goster' => '1'
                                  ));
                              }
                              if($durumValue == '5'  ) {
                                  $guncelle = $db->prepare("UPDATE urun SET
                                    fiyat_goster=:fiyat_goster
                                     WHERE id={$inRow['id']}      
                                    ");
                                  $sonuc = $guncelle->execute(array(
                                      'fiyat_goster' => '2'
                                  ));
                              }
                              if($durumValue == '6'  ) {
                                  $guncelle = $db->prepare("UPDATE urun SET
                                    fiyat_goster=:fiyat_goster
                                     WHERE id={$inRow['id']}      
                                    ");
                                  $sonuc = $guncelle->execute(array(
                                      'fiyat_goster' => '3'
                                  ));
                              }
                              if($durumValue == '7'  ) {
                                  $guncelle = $db->prepare("UPDATE urun SET
                                    durum=:durum
                                     WHERE id={$inRow['id']}      
                                    ");
                                  $sonuc = $guncelle->execute(array(
                                      'durum' => '1'
                                  ));
                              }
                              if($durumValue == '8'  ) {
                                  $guncelle = $db->prepare("UPDATE urun SET
                                    gorunmez=:gorunmez
                                     WHERE id={$inRow['id']}      
                                    ");
                                  $sonuc = $guncelle->execute(array(
                                      'gorunmez' => '0'
                                  ));
                              }

                          }else{
                              header('Location:'.$ayar['site_url'].'404');
                              exit();
                          }
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
                /*  <========SON=========>>> Durum Güncellemesi SON */

            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }else{
            $_SESSION['main_alert'] = 'multi_update_emptyerror';
            header('Location:'.$ayar['panel_url'].'pages.php?page=allupdate_product');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}