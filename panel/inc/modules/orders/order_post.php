<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'return_delete' || $_GET['status'] == 'order_cancel' || $_GET['status'] == 'product_stock'  || $_GET['status'] == 'stock_load' || $_GET['status'] == 'return_product_update' || $_GET['status'] == 'offer_delete'  || $_GET['status'] == 'offer_update' || $_GET['status'] == 'op_order_delete' || $_GET['status'] == 'op_order_update' || $_GET['status'] == 'order_delete' || $_GET['status'] == 'invoice_download' || $_GET['status'] == 'product_update' || $_GET['status'] == 'note_delete' || $_GET['status'] == 'note_add' || $_GET['status'] == 'product_cargo_update' || $_GET['status'] == 'cargo_settings' || $_GET['status'] == 'transfer_no' || $_GET['status'] == 'transfer_delete' || $_GET['status'] == 'transfer_pasive' || $_GET['status'] == 'transfer_confirm' || $_GET['status'] == 'cancel_request_delete' || $_GET['status'] == 'cancel_noti' || $_GET['status'] == 'invoice_add' || $_GET['status'] == 'invoice_delete' || $_GET['status'] == 'change' || $_GET['status'] == 'order_active'  ) {

            $timestamp = date('Y-m-d G:i:s');

            if($_GET['status'] == 'return_delete') {
                if (isset($_GET['no'])) {
                    $silmeislem = $db->prepare("DELETE from siparis_urunler_iade WHERE talep_no=:talep_no");
                    $sil = $silmeislem->execute(array(
                        'talep_no' => $_GET['no']
                    ));
                    if($sil) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=order_product_return');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }


            /* Stokları Geri al */
            if($_GET['status'] == 'stock_load') {
                if (isset($_GET['orderID']) && $_GET['orderID']>'0') {
                    if($odemeRow['urun_stok_dus'] == '1'  ) {
                        $siparisCek = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                        $siparisCek->execute(array(
                            'siparis_no' => $_GET['orderID'],
                        ));

                        if($siparisCek->rowCount()>'0' ) {
                            $siparisRow = $siparisCek->fetch(PDO::FETCH_ASSOC);

                            if($siparisRow['stok_alindi'] !='1' ) {
                                $siparisUrunleri = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
                                $siparisUrunleri->execute(array(
                                    'siparis_id' => $_GET['orderID'],
                                ));
                                if($siparisUrunleri->rowCount()>'0'  ) {

                                    foreach ($siparisUrunleri as $urunRow){

                                        $adet = $urunRow['adet'];
                                        /* alındı kaydı */
                                        $guncelle = $db->prepare("UPDATE siparisler SET
                                            stok_alindi=:stok_alindi
                                     WHERE siparis_no={$_GET['orderID']}      
                                    ");
                                        $sonuc = $guncelle->execute(array(
                                            'stok_alindi' => '1',
                                        ));

                                        $guncelle = $db->prepare("UPDATE siparis_urunler SET
                                            stok_alindi=:stok_alindi
                                     WHERE id={$urunRow['id']}      
                                    ");
                                        $sonuc = $guncelle->execute(array(
                                            'stok_alindi' => '1',
                                        ));
                                        /*  <========SON=========>>> alındı kaydı SON */

                                        if($urunRow['varyant_stok_durum'] == '0'  ) {
                                            $realProduct = $db->prepare("select stok from urun where id=:id ");
                                            $realProduct->execute(array(
                                                'id' => $urunRow['urun_id'],
                                            ));
                                            $realRow = $realProduct->fetch(PDO::FETCH_ASSOC);
                                            $guncelle = $db->prepare("UPDATE urun SET
                                            stok=:stok
                                     WHERE id={$urunRow['urun_id']}      
                                    ");
                                            $sonuc = $guncelle->execute(array(
                                                'stok' => $realRow['stok']+$adet
                                            ));
                                        }

                                        if($urunRow['varyant_stok_durum'] == '1'  ) {
                                            $VaryantStokCheck = $db->prepare("select * from detay_varyant_stok where stok_kodu=:stok_kodu  ");
                                            $VaryantStokCheck->execute(array(
                                                'stok_kodu' => $urunRow['stok_kodu'],
                                            ));
                                            if($VaryantStokCheck->rowCount()>'0' ) {
                                                $stokRow = $VaryantStokCheck->fetch(PDO::FETCH_ASSOC);
                                                $guncelle = $db->prepare("UPDATE detay_varyant_stok SET
                                                 stok=:stok
                                          WHERE id=$stokRow[id]      
                                         ");
                                                $sonuc = $guncelle->execute(array(
                                                    'stok' => $stokRow['stok']+$adet,
                                                ));
                                            }
                                        }

                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['orderID'].'');

                                    }

                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }else{
                                header('Location:'.$ayar['site_url'].'404');

                            }

                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Stokları Geri al SON */

            /* Ürün Bazlı Stok Geri Al */
            if($_GET['status'] == 'product_stock') {
                if (isset($_GET['orderID']) && $_GET['orderID'] > '0') {

                    $siparisUrunleri = $db->prepare("select * from siparis_urunler where id=:id ");
                    $siparisUrunleri->execute(array(
                        'id' => $_GET['orderID'],
                    ));
                    if($siparisUrunleri->rowCount()>'0'  ) {
                        $urunRow = $siparisUrunleri->fetch(PDO::FETCH_ASSOC);
                        if($urunRow['stok_alindi'] !='1' ) {
                            $adet = $urunRow['adet'];
                            $guncelle = $db->prepare("UPDATE siparis_urunler SET
                                            stok_alindi=:stok_alindi
                                     WHERE id={$_GET['orderID']}      
                                    ");
                            $sonuc = $guncelle->execute(array(
                                'stok_alindi' => '1',
                            ));
                            /*  <========SON=========>>> alındı kaydı SON */

                            if($urunRow['varyant_stok_durum'] == '0'  ) {
                                $realProduct = $db->prepare("select stok from urun where id=:id ");
                                $realProduct->execute(array(
                                    'id' => $urunRow['urun_id'],
                                ));
                                $realRow = $realProduct->fetch(PDO::FETCH_ASSOC);
                                $guncelle = $db->prepare("UPDATE urun SET
                                            stok=:stok
                                     WHERE id={$urunRow['urun_id']}      
                                    ");
                                $sonuc = $guncelle->execute(array(
                                    'stok' => $realRow['stok']+$adet
                                ));
                            }

                            if($urunRow['varyant_stok_durum'] == '1'  ) {
                                $VaryantStokCheck = $db->prepare("select * from detay_varyant_stok where stok_kodu=:stok_kodu  ");
                                $VaryantStokCheck->execute(array(
                                    'stok_kodu' => $urunRow['stok_kodu'],
                                ));
                                if($VaryantStokCheck->rowCount()>'0' ) {
                                    $stokRow = $VaryantStokCheck->fetch(PDO::FETCH_ASSOC);
                                    $guncelle = $db->prepare("UPDATE detay_varyant_stok SET
                                                 stok=:stok
                                          WHERE id=$stokRow[id]      
                                         ");
                                    $sonuc = $guncelle->execute(array(
                                        'stok' => $stokRow['stok']+$adet,
                                    ));
                                }
                            }
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['backID'].'');
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Ürün Bazlı Stok Geri Al SON */


            if($_GET['status'] == 'return_product_update') {
                if ($_POST && $_POST['request_id'] && $_POST['order_id'] && isset($_POST['update'])) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_POST['order_id'],
                    ));
                    if($siparis->rowCount()>'0' ) {
                        $sipRow = $siparis->fetch(PDO::FETCH_ASSOC);
                        $iptalSorgu = $db->prepare("select * from siparis_urunler_iade where talep_no=:talep_no ");
                        $iptalSorgu->execute(array(
                            'talep_no' => $_POST['request_id'],
                        ));
                        $iptalRow = $iptalSorgu->fetch(PDO::FETCH_ASSOC);
                        if($iptalSorgu->rowCount()>'0' ) {

                            $siparisUrunleri = $db->prepare("select urun_baslik from siparis_urunler where id=:id ");
                            $siparisUrunleri->execute(array(
                                'id' => $iptalRow['urun_id'],
                            ));
                            $urun = $siparisUrunleri->fetch(PDO::FETCH_ASSOC);

                          /* Durumu Güncelle */
                          $guncelle = $db->prepare("UPDATE siparis_urunler_iade SET
                                  durum=:durum
                           WHERE talep_no={$_POST['request_id']}      
                          ");
                          $sonuc = $guncelle->execute(array(
                              'durum' => $_POST['durum'],
                          ));
                          if($sonuc){

                              if($_POST['durum_kargo'] == '1'  ) {
                                  $kargoistek= '1';
                                  $kargoID = $_POST['kargo_idler'];
                                  foreach ($kargoID as $ID) {
                                      $kargoIDleri .=$ID.',';
                                  }
                                  $kargoAdres = $_POST['adres'];
                              }else{
                                  $kargoistek= '0';
                                  $kargoIDleri = null;
                                  $kargoAdres = null;
                              }

                              if($_POST['iade_tutar'] == !null  ) {
                               $iadeTutar = $_POST['iade_tutar'];
                              }else{
                                  $iadeTutar = '0';
                              }

                              $guncelle = $db->prepare("UPDATE siparis_urunler_iade SET
                                          kargo_idler=:kargo_idler,
                                          durum_kargo=:durum_kargo,
                                          adres=:adres,
                                          iban_iste=:iban_iste,
                                          para_iade=:para_iade,
                                          iade_tutar=:iade_tutar,
                                          iade_olumsuz_sebep=:iade_olumsuz_sebep
                                   WHERE talep_no={$_POST['request_id']}      
                                  ");
                              $sonuc = $guncelle->execute(array(
                                  'kargo_idler' => $kargoIDleri,
                                  'durum_kargo' => $kargoistek,
                                  'adres' => $kargoAdres,
                                  'iban_iste' => $_POST['iban_iste'],
                                  'para_iade' => $_POST['para_iade'],
                                  'iade_tutar' => $iadeTutar,
                                  'iade_olumsuz_sebep' => trim(strip_tags($_POST['iade_olumsuz_sebep'])),
                              ));
                              /* SİTE İÇİ BİLDİRİM */
                              if($_POST['noti']=='1'  ) {
                                  if($notiSet['durum'] == '1' ) {
                                          $user = $sipRow['uye_id'];
                                          $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                          $kullaniciCek->execute(array(
                                              'id' => $user
                                          ));
                                          if($kullaniciCek->rowCount()>'0'  ) {
                                              $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                              $rand = rand(0,(int) 9999999999);
                                              if($_POST['durum'] == '0'  ) {
                                                  $kaynak = $diller['adminpanel-bildirim-text-39'];
                                                  $kaynak  = $kaynak;
                                                  $eski   = array('{urun_adi}');
                                                  $yeni   = array($urun['urun_baslik']);
                                                  $kaynak = str_replace($eski, $yeni, $kaynak);
                                                  $baslik = $diller['adminpanel-bildirim-text-38'];
                                                  $icerik = ''.$diller['adminpanel-bildirim-text-2'].' <strong>'.$userRow['isim'].' '.$userRow['soyisim'].'</strong>, <br><br> <strong>#'.$sipRow['siparis_no'].'</strong> '.$kaynak.'';
                                              }

                                              if($_POST['durum'] == '1'  ) {
                                                  if($_POST['durum_kargo'] == '0'  ) {
                                                      $kaynak = $diller['adminpanel-bildirim-text-37'];
                                                      $kaynak  = $kaynak;
                                                      $eski   = array('{urun_adi}','{iade_durum}','{talep_no}');
                                                      $yeni   = array($urun['urun_baslik'],''.'<strong>'.$diller['adminpanel-form-text-1569'].'</strong>'.'',''.'#'.$_POST['request_id'].'');
                                                      $kaynak = str_replace($eski, $yeni, $kaynak);
                                                      $baslik = $diller['adminpanel-bildirim-text-36'];
                                                      $icerik = ''.$diller['adminpanel-bildirim-text-2'].' <strong>'.$userRow['isim'].' '.$userRow['soyisim'].'</strong>, <br><br> <strong>#'.$sipRow['siparis_no'].'</strong> '.$kaynak.'';
                                                  }else{
                                                      $kaynak = $diller['adminpanel-bildirim-text-37'];
                                                      $kaynak  = $kaynak;
                                                      $eski   = array('{urun_adi}','{iade_durum}','{talep_no}');
                                                      $yeni   = array($urun['urun_baslik'],''.'<strong>'.$diller['adminpanel-form-text-1569'].'</strong>'.'',''.'#'.$_POST['request_id'].'');
                                                      $kaynak = str_replace($eski, $yeni, $kaynak);
                                                      $baslik = $diller['adminpanel-bildirim-text-36'];
                                                      $icerik = ''.$diller['adminpanel-bildirim-text-2'].' <strong>'.$userRow['isim'].' '.$userRow['soyisim'].'</strong>, <br><br> <strong>#'.$sipRow['siparis_no'].'</strong> '.$kaynak.'<br><br>'.$diller['adminpanel-bildirim-text-40'].'';
                                                  }
                                              }

                                              if($_POST['durum'] == '2'  ) {
                                                  $kaynak = $diller['adminpanel-bildirim-text-41'];
                                                  $kaynak  = $kaynak;
                                                  $eski   = array('{urun_adi}','{talep_no}');
                                                  $yeni   = array($urun['urun_baslik'],''.'#'.$_POST['request_id'].'');
                                                  $kaynak = str_replace($eski, $yeni, $kaynak);
                                                  $baslik = $diller['adminpanel-bildirim-text-42'];
                                                  $icerik = ''.$diller['adminpanel-bildirim-text-2'].' <strong>'.$userRow['isim'].' '.$userRow['soyisim'].'</strong>, <br><br> <strong>#'.$sipRow['siparis_no'].'</strong> '.$kaynak.'';
                                              }

                                              if($_POST['durum'] == '3'  ) {
                                                  $kaynak1 = $diller['adminpanel-bildirim-text-44'];
                                                  $kaynak1  = $kaynak1;
                                                  $eski   = array('{urun_adi}');
                                                  $yeni   = array($urun['urun_baslik']);
                                                  $kaynak1 = str_replace($eski, $yeni, $kaynak1);

                                                  if($_POST['iade_olumsuz_sebep'] == !null  ) {
                                                      $kaynak2 = $diller['adminpanel-bildirim-text-45'];
                                                      $kaynak2  = $kaynak2;
                                                      $eski2   = array('{sebep}');
                                                      $yeni2   = array($_POST['iade_olumsuz_sebep']);
                                                      $kaynak2 = str_replace($eski2, $yeni2, $kaynak2);
                                                  }else{
                                                      $kaynak2 = null;
                                                  }

                                                  $baslik = $diller['adminpanel-bildirim-text-43'];
                                                  $icerik = ''.$diller['adminpanel-bildirim-text-2'].' <strong>'.$userRow['isim'].' '.$userRow['soyisim'].'</strong>, <br><br> <strong>#'.$sipRow['siparis_no'].'</strong> '.$kaynak1.' <br><br>'.$kaynak2.'';
                                              }
                                              /* Site içi bildirim gönder */
                                              $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                            bildirim_id=:bildirim_id,
                                                            baslik=:baslik,
                                                            icerik=:icerik,
                                                            tarih=:tarih,
                                                            tur=:tur,
                                                            ikon=:ikon,
                                                            uye_id=:uye_id,
                                                            durum=:durum,
                                                            dil=:dil
                                                            ");
                                              $sonuc = $kaydet->execute(array(
                                                  'bildirim_id' => $rand,
                                                  'baslik' => $baslik,
                                                  'icerik' => $icerik,
                                                  'tarih' => $timestamp,
                                                  'tur' => '2',
                                                  'ikon' => '',
                                                  'uye_id' => $user,
                                                  'durum' => '1',
                                                  'dil' => $_SESSION['dil']
                                              ));
                                              /*  <========SON=========>>> Site içi bildirim gönder SON */
                                          }
                                  }
                              }
                              /*  <========SON=========>>> SİTE İÇİ BİLDİRİM SON */
                              /* SMS */
                              if($_POST['sms_noti']=='1'  ) {
                                  if($sms['durum'] == '1' ) {
                                      $isim = $sipRow['isim'];
                                      $soyisim = $sipRow['soyisim'];
                                      $numara = $sipRow['telefon'];

                                      if($_POST['durum'] == '0'  ) {
                                          $kaynak = $diller['adminpanel-bildirim-text-39'];
                                          $kaynak  = $kaynak;
                                          $eski   = array('{urun_adi}');
                                          $yeni   = array($urun['urun_baslik']);
                                          $kaynak = str_replace($eski, $yeni, $kaynak);
                                          $baslik = $diller['adminpanel-bildirim-text-38'];
                                          $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$sipRow['siparis_no'].' '.$kaynak.'';
                                      }
                                      if($_POST['durum'] == '1'  ) {
                                          if($_POST['durum_kargo'] == '0'  ) {
                                              $kaynak = $diller['adminpanel-bildirim-text-37'];
                                              $kaynak  = $kaynak;
                                              $eski   = array('{urun_adi}','{iade_durum}','{talep_no}');
                                              $yeni   = array($urun['urun_baslik'],$diller['adminpanel-form-text-1569'],''.'#'.$_POST['request_id'].'');
                                              $kaynak = str_replace($eski, $yeni, $kaynak);
                                              $baslik = $diller['adminpanel-bildirim-text-36'];
                                              $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$sipRow['siparis_no'].' '.$kaynak.'';
                                          }else{
                                              $kaynak = $diller['adminpanel-bildirim-text-37'];
                                              $kaynak  = $kaynak;
                                              $eski   = array('{urun_adi}','{iade_durum}','{talep_no}');
                                              $yeni   = array($urun['urun_baslik'],$diller['adminpanel-form-text-1569'],''.'#'.$_POST['request_id'].'');
                                              $kaynak = str_replace($eski, $yeni, $kaynak);
                                              $baslik = $diller['adminpanel-bildirim-text-36'];
                                              $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$sipRow['siparis_no'].' '.$kaynak.' '.$diller['adminpanel-bildirim-text-40'].'';
                                          }
                                      }
                                      if($_POST['durum'] == '2'  ) {
                                          $kaynak = $diller['adminpanel-bildirim-text-41'];
                                          $kaynak  = $kaynak;
                                          $eski   = array('{urun_adi}','{talep_no}');
                                          $yeni   = array($urun['urun_baslik'],''.'#'.$_POST['request_id'].'');
                                          $kaynak = str_replace($eski, $yeni, $kaynak);
                                          $baslik = $diller['adminpanel-bildirim-text-42'];
                                          $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$sipRow['siparis_no'].' '.$kaynak.'';
                                      }
                                      if($_POST['durum'] == '3'  ) {
                                          $kaynak1 = $diller['adminpanel-bildirim-text-44'];
                                          $kaynak1  = $kaynak1;
                                          $eski   = array('{urun_adi}');
                                          $yeni   = array($urun['urun_baslik']);
                                          $kaynak1 = str_replace($eski, $yeni, $kaynak1);

                                          if($_POST['iade_olumsuz_sebep'] == !null  ) {
                                              $kaynak2 = $diller['adminpanel-bildirim-text-45'];
                                              $kaynak2  = $kaynak2;
                                              $eski2   = array('{sebep}');
                                              $yeni2   = array($_POST['iade_olumsuz_sebep']);
                                              $kaynak2 = str_replace($eski2, $yeni2, $kaynak2);
                                          }else{
                                              $kaynak2 = null;
                                          }

                                          $baslik = $diller['adminpanel-bildirim-text-43'];
                                          $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$sipRow['siparis_no'].' '.$kaynak1.' '.$kaynak2.'';
                                      }
                                      include 'inc/modules/orders/order_noti_sms.php';
                                  }
                              }
                              /*  <========SON=========>>> SMS SON */
                              /* E-POSTA */
                              if($_POST['email_noti']=='1'  ) {
                                  if($ayar['smtp_durum'] == '1' ) {
                                          $eposta = $sipRow['eposta'];
                                          $isim = $sipRow['isim'];
                                          $soyisim = $sipRow['soyisim'];
                                          include 'inc/modules/orders/order_product_return_noti_email.php';
                                  }
                              }
                              /*  <========SON=========>>> E-POSTA SON */



                              $_SESSION['collepse_status'] = 'status';
                              header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_return&no='.$_POST['request_id'].'');
                          }else{
                          echo 'Veritabanı Hatası';
                          }
                          /*  <========SON=========>>> Durumu Güncelle SON */


                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'offer_delete') {
                if (isset($_GET['no'])) {
                    $silmeislem = $db->prepare("DELETE from siparis_teklif WHERE teklif_no=:teklif_no");
                    $sil = $silmeislem->execute(array(
                        'teklif_no' => $_GET['no']
                    ));
                    if($sil) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=offers');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'offer_update'  ) {
                if ($_POST && $_POST['offer_id']  && isset($_POST['update'])) {

                    $siparis = $db->prepare("select * from siparis_teklif where id=:id ");
                    $siparis->execute(array(
                        'id' => $_POST['offer_id'],
                    ));
                    if($siparis->rowCount()>'0' ) {
                        $guncelle = $db->prepare("UPDATE siparis_teklif SET
                             durum=:durum,  
                             teklif_icerik=:teklif_icerik
                        WHERE id={$_POST['offer_id']}      
                       ");
                        $sonuc = $guncelle->execute(array(
                            'durum' => $_POST['durum'],
                            'teklif_icerik' => $_POST['teklif_icerik']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=offers');
                            /* SİTE İÇİ BİLDİRİM */
                            if($_POST['noti']=='1'  ) {
                                if($notiSet['durum'] == '1' ) {
                                    $sips = $db->prepare("select * from siparis_teklif where id=:id ");
                                    $sips->execute(array(
                                        'id' => $_POST['offer_id'],
                                    ));
                                    if($sips->rowCount()>'0'  ) {
                                        $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                        $user = $sipRow['uye_id'];
                                        $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                        $kullaniciCek->execute(array(
                                            'id' => $user
                                        ));
                                        if($kullaniciCek->rowCount()>'0'  ) {
                                            $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                            $rand = rand(0,(int) 9999999999);
                                            $baslik = $diller['adminpanel-bildirim-text-30'];
                                            $icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$sipRow['teklif_no'].' '.$diller['adminpanel-bildirim-text-33'].'';
                                            /* Site içi bildirim gönder */
                                            $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                            bildirim_id=:bildirim_id,
                                                            baslik=:baslik,
                                                            icerik=:icerik,
                                                            tarih=:tarih,
                                                            tur=:tur,
                                                            ikon=:ikon,
                                                            uye_id=:uye_id,
                                                            durum=:durum,
                                                            dil=:dil
                                                            ");
                                            $sonuc = $kaydet->execute(array(
                                                'bildirim_id' => $rand,
                                                'baslik' => $baslik,
                                                'icerik' => $icerik,
                                                'tarih' => $timestamp,
                                                'tur' => '2',
                                                'ikon' => '',
                                                'uye_id' => $user,
                                                'durum' => '1',
                                                'dil' => $_SESSION['dil']
                                            ));
                                            /*  <========SON=========>>> Site içi bildirim gönder SON */
                                        }
                                    }
                                }
                            }
                            /*  <========SON=========>>> SİTE İÇİ BİLDİRİM SON */
                            /* SMS */
                            if($_POST['sms_noti']=='1'  ) {
                                if($sms['durum'] == '1' ) {
                                    $sips = $db->prepare("select * from siparis_teklif where id=:id ");
                                    $sips->execute(array(
                                        'id' => $_POST['offer_id'],
                                    ));
                                    if($sips->rowCount()>'0'  ) {
                                        $sipRow = $sips->fetch(PDO::FETCH_ASSOC);

                                        $teklif = $sipRow['teklif_icerik'];
                                        $isim = $sipRow['isim'];
                                        $soyisim = $sipRow['soyisim'];
                                        $numara = $sipRow['telefon'];
                                        $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$sipRow['teklif_no'].' '.$diller['adminpanel-bildirim-text-35'].' '.$teklif.'';
                                        include 'inc/modules/orders/order_noti_sms.php';
                                    }
                                }
                            }
                            /*  <========SON=========>>> SMS SON */
                            /* E-POSTA */
                            if($_POST['email_noti']=='1'  ) {
                                if($ayar['smtp_durum'] == '1' ) {
                                    $sips = $db->prepare("select * from siparis_teklif where id=:id ");
                                    $sips->execute(array(
                                        'id' => $_POST['offer_id'],
                                    ));
                                    if($sips->rowCount()>'0'  ) {
                                        $sipRow = $sips->fetch(PDO::FETCH_ASSOC);

                                        $teklif = $sipRow['teklif_icerik'];
                                        $user = $sipRow['uye_id'];
                                        $eposta = $sipRow['eposta'];
                                        $isim = $sipRow['isim'];
                                        $soyisim = $sipRow['soyisim'];
                                        include 'inc/modules/orders/offer_noti_email.php';
                                    }
                                }
                            }
                            /*  <========SON=========>>> E-POSTA SON */
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }



            if($_GET['status'] == 'op_order_update'  ) {
                if ($_POST && $_POST['op_id'] && $_POST['durum'] && isset($_POST['update'])) {

                    $siparis = $db->prepare("select * from siparis_normal where id=:id ");
                    $siparis->execute(array(
                        'id' => $_POST['op_id'],
                    ));
                    if($siparis->rowCount()>'0' ) {
                       $guncelle = $db->prepare("UPDATE siparis_normal SET
                             durum=:durum,  
                             kargo_ver=:kargo_ver,
                             kargo_firma=:kargo_firma,
                             kargo_takip=:kargo_takip
                        WHERE id={$_POST['op_id']}      
                       ");
                       $sonuc = $guncelle->execute(array(
                           'durum' => $_POST['durum'],
                           'kargo_ver' => $_POST['kargo_ver'],
                           'kargo_firma' => $_POST['kargo_firma'],
                           'kargo_takip' => $_POST['kargo_takip']
                       ));
                       if($sonuc){
                           $_SESSION['main_alert'] = 'success';
                           header('Location:'.$ayar['panel_url'].'pages.php?page=op_orders');



                           /* SİTE İÇİ BİLDİRİM */
                           if($_POST['noti']=='1'  ) {
                               if($notiSet['durum'] == '1' ) {
                                   $sips = $db->prepare("select * from siparis_normal where id=:id ");
                                   $sips->execute(array(
                                       'id' => $_POST['op_id'],
                                   ));


                                   if($sips->rowCount()>'0'  ) {
                                       $sipRow = $sips->fetch(PDO::FETCH_ASSOC);

                                       $kargoFirmaCek = $db->prepare("select * from kargo_firma where id=:id ");
                                       $kargoFirmaCek->execute(array(
                                           'id' => $sipRow['kargo_firma'],
                                       ));
                                       $kargoRows = $kargoFirmaCek->fetch(PDO::FETCH_ASSOC);

                                       if($kargoFirmaCek->rowCount()>'0'  ) {
                                           $kargofirma = $kargoRows['baslik'];
                                       }else{
                                           $kargofirma = $kargoRows['baslik'];
                                       }
                                       $kargotakip = $_POST['kargo_takip'];

                                       if($sipRow['kargo_ver']== '1' && $sipRow['kargo_firma'] == !null && $sipRow['kargo_takip'] == !null   ) {
                                           $ayrica = '
                                    <br><br>
                                   <strong> '.$diller['adminpanel-bildirim-text-29'].'  '.$diller['adminpanel-bildirim-text-25'].'</strong>
                                    <br>
                                    '.$diller['adminpanel-bildirim-text-21'].' '.$kargofirma.'
                                    <br>
                                    '.$diller['adminpanel-bildirim-text-22'].'  '.$kargotakip.'
                                    ';
                                       }else{
                                           $ayrica = null;
                                       }


                                       $user = $sipRow['uye_id'];
                                       $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                       $kullaniciCek->execute(array(
                                           'id' => $user
                                       ));
                                       if($kullaniciCek->rowCount()>'0'  ) {
                                           $durum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                           $durum->execute(array(
                                               'id' => $sipRow['durum'],
                                           ));
                                           $d = $durum->fetch(PDO::FETCH_ASSOC);
                                           $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                           $rand = rand(0,(int) 9999999999);
                                           $baslik = $diller['adminpanel-bildirim-text-15'];
                                           $icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$sipRow['siparis_no'].' '.$diller['adminpanel-bildirim-text-16'].' <strong>'.$d['baslik'].'</strong>  '.$diller['adminpanel-bildirim-text-28'].' '.$ayrica.'';
                                           /* Site içi bildirim gönder */
                                           $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                                    bildirim_id=:bildirim_id,
                                                                    baslik=:baslik,
                                                                    icerik=:icerik,
                                                                    tarih=:tarih,
                                                                    tur=:tur,
                                                                    ikon=:ikon,
                                                                    uye_id=:uye_id,
                                                                    durum=:durum,
                                                                    dil=:dil
                                                                    ");
                                           $sonuc = $kaydet->execute(array(
                                               'bildirim_id' => $rand,
                                               'baslik' => $baslik,
                                               'icerik' => $icerik,
                                               'tarih' => $timestamp,
                                               'tur' => '2',
                                               'ikon' => '&#128722',
                                               'uye_id' => $user,
                                               'durum' => '1',
                                               'dil' => $_SESSION['dil']
                                           ));
                                           /*  <========SON=========>>> Site içi bildirim gönder SON */

                                       }
                                   }
                               }
                           }
                           /*  <========SON=========>>> SİTE İÇİ BİLDİRİM SON */
                           /* SMS */
                           if($_POST['sms_noti']=='1'  ) {
                               if($sms['durum'] == '1' ) {
                                   $sips = $db->prepare("select * from siparis_normal where id=:id ");
                                   $sips->execute(array(
                                       'id' => $_POST['op_id'],
                                   ));
                                   if($sips->rowCount()>'0'  ) {
                                       $sipRow = $sips->fetch(PDO::FETCH_ASSOC);

                                       $kargoFirmaCek = $db->prepare("select * from kargo_firma where id=:id ");
                                       $kargoFirmaCek->execute(array(
                                           'id' => $sipRow['kargo_firma'],
                                       ));
                                       $kargoRows = $kargoFirmaCek->fetch(PDO::FETCH_ASSOC);

                                       if($kargoFirmaCek->rowCount()>'0'  ) {
                                           $kargofirma = $kargoRows['baslik'];
                                       }else{
                                           $kargofirma = $kargoRows['baslik'];
                                       }
                                       $kargotakip = $_POST['kargo_takip'];

                                       if($sipRow['kargo_ver']== '1' && $sipRow['kargo_firma'] == !null && $sipRow['kargo_takip'] == !null   ) {
                                           $ayrica = ''.$diller['adminpanel-bildirim-text-29'].' '.$diller['adminpanel-bildirim-text-25'].'
                                                        '.$diller['adminpanel-bildirim-text-21'].' '.$kargofirma.'
                                                        '.$diller['adminpanel-bildirim-text-22'].'  '.$kargotakip.'
                                                        ';
                                       }else{
                                           $ayrica = null;
                                       }

                                       $durum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                       $durum->execute(array(
                                           'id' => $sipRow['durum'],
                                       ));
                                       $d = $durum->fetch(PDO::FETCH_ASSOC);

                                       $isim = $sipRow['isim'];
                                       $soyisim = $sipRow['soyisim'];
                                       $numara = $sipRow['telefon'];
                                       $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$sipRow['siparis_no'].' '.$diller['adminpanel-bildirim-text-16'].' '.$d['baslik'].' '.$diller['adminpanel-bildirim-text-28'].' '.$ayrica.'';
                                       include 'inc/modules/orders/order_noti_sms.php';
                                   }
                               }
                           }
                           /*  <========SON=========>>> SMS SON */
                           /* E-POSTA */
                           if($_POST['email_noti']=='1'  ) {
                               if($ayar['smtp_durum'] == '1' ) {
                                   $sips = $db->prepare("select * from siparis_normal where id=:id ");
                                   $sips->execute(array(
                                       'id' => $_POST['op_id'],
                                   ));
                                   if($sips->rowCount()>'0'  ) {
                                       $sipRow = $sips->fetch(PDO::FETCH_ASSOC);

                                       $durum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                       $durum->execute(array(
                                           'id' => $sipRow['durum'],
                                       ));
                                       $d = $durum->fetch(PDO::FETCH_ASSOC);

                                       $kargoFirmaCek = $db->prepare("select * from kargo_firma where id=:id ");
                                       $kargoFirmaCek->execute(array(
                                           'id' => $sipRow['kargo_firma'],
                                       ));
                                       $kargoRows = $kargoFirmaCek->fetch(PDO::FETCH_ASSOC);

                                       if($kargoFirmaCek->rowCount()>'0'  ) {
                                           $kargofirma = $kargoRows['baslik'];
                                       }else{
                                           $kargofirma = $kargoRows['baslik'];
                                       }
                                       $kargotakip = $_POST['kargo_takip'];

                                       if($sipRow['kargo_ver']== '1' && $sipRow['kargo_firma'] == !null && $sipRow['kargo_takip'] == !null   ) {
                                           $ayrica = '
                                    <br>
                                   <strong> '.$diller['adminpanel-bildirim-text-29'].'  '.$diller['adminpanel-bildirim-text-25'].'</strong>
                                    <br>
                                    '.$diller['adminpanel-bildirim-text-21'].' '.$kargofirma.'
                                    <br>
                                    '.$diller['adminpanel-bildirim-text-22'].'  '.$kargotakip.'
                                    ';
                                       }else{
                                           $ayrica = null;
                                       }

                                       $user = $sipRow['uye_id'];
                                       $eposta = $sipRow['eposta'];
                                       $isim = $sipRow['isim'];
                                       $soyisim = $sipRow['soyisim'];
                                       include 'inc/modules/orders/single_order_noti_email.php';
                                   }
                               }
                           }
                           /*  <========SON=========>>> E-POSTA SON */

                       }else{
                       echo 'Veritabanı Hatası';
                       }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }


            if($_GET['status'] == 'op_order_delete') {
                if (isset($_GET['no'])) {
                    $silmeislem = $db->prepare("DELETE from siparis_normal WHERE siparis_no=:siparis_no");
                    $sil = $silmeislem->execute(array(
                        'siparis_no' => $_GET['no']
                    ));
                    if($sil) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=op_orders');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /* OrderDelete */
            if($_GET['status'] == 'order_delete'  ) {
                if( isset($_GET['no']) ) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_GET['no'],
                    ));
                    if($siparis->rowCount()>'0' ) {

                        $silmeislem = $db->prepare("DELETE from siparisler WHERE siparis_no=:siparis_no");
                        $sil = $silmeislem->execute(array(
                        'siparis_no' => $_GET['no']
                        ));
                        if($sil) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=orders');

                            /* Ürünleri sil */
                            $a = $db->prepare("DELETE from siparis_urunler WHERE siparis_id=:siparis_id");
                            $a->execute(array(
                            'siparis_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> Ürünleri sil SON */

                            /* E-Fatura varsa sil */
                            $fatura = $db->prepare("select * from siparis_fatura where siparis_no=:siparis_no ");
                            $fatura->execute(array(
                                'siparis_no' => $_GET['no'],
                            ));
                            if($fatura->rowCount()>'0'  ) {
                                $fat = $fatura->fetch(PDO::FETCH_ASSOC);
                             unlink('../i/invoice/'.$fat['fatura_url'].'');
                                $fff = $db->prepare("DELETE from siparis_fatura WHERE siparis_no=:siparis_no");
                                $fff->execute(array(
                                    'siparis_no' => $_GET['no']
                                ));
                            }
                            /*  <========SON=========>>> E-Fatura varsa sil SON */

                            /* sipariş iptal sil */
                            $b = $db->prepare("DELETE from siparis_iptal WHERE siparis_no=:siparis_no");
                            $b->execute(array(
                                'siparis_no' => $_GET['no']
                            ));
                            /*  <========SON=========>>> sipariş iptal sil SON */

                            /* İade Talep sil */
                            $c = $db->prepare("DELETE from siparis_urunler_iade WHERE siparis_no=:siparis_no");
                            $c->execute(array(
                                'siparis_no' => $_GET['no']
                            ));
                            /*  <========SON=========>>> İade Talep sil SON */

                            /* Parça kargoları sil */
                            $d = $db->prepare("DELETE from siparis_kargo WHERE siparis_id=:siparis_id");
                            $d->execute(array(
                                'siparis_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> Parça kargoları sil SON */

                            /* siparişte varyant varsa sil */
                            $e = $db->prepare("DELETE from siparis_varyant WHERE siparis_id=:siparis_id");
                            $e->execute(array(
                                'siparis_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> siparişte varyant varsa sil SON */

                            /* Notları sil */
                            $f = $db->prepare("DELETE from operator_not WHERE siparis_no=:siparis_no");
                            $f->execute(array(
                                'siparis_no' => $_GET['no']
                            ));
                            /*  <========SON=========>>> Notları sil SON */
                        }else {
                        echo 'veritabanı hatası';
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> OrderDelete SON */


            if($_GET['status'] == 'invoice_download'  ) {
                $sor = $db->prepare("select * from siparis_fatura where siparis_no=:siparis_no ");
                $sor->execute(array(
                    'siparis_no' => $_GET['no'],
                ));
                $s = $sor->fetch(PDO::FETCH_ASSOC);
                $file = '../i/invoice/'.$s['fatura_url'].'';
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($file));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                exit;
            }

            /* Product Status */
            if($_GET['status'] == 'product_update'  ) {
                if ($_POST && $_POST['order_id'] && $_POST['pro_id'] && isset($_POST['productUpdate'])) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_POST['order_id'],
                    ));
                    if($siparis->rowCount()>'0' ) {
                        $siparis_urun = $db->prepare("select * from siparis_urunler where id=:id and siparis_id=:siparis_id");
                        $siparis_urun->execute(array(
                            'id' => $_POST['pro_id'],
                            'siparis_id' => $_POST['order_id']
                        ));
                        if($siparis_urun->rowCount()>'0'  ) {
                            $guncelle = $db->prepare("UPDATE siparis_urunler SET
                                    durum=:durum,
                                    iade_aksiyon=:iade_aksiyon
                             WHERE id={$_POST['pro_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'durum' => $_POST['durum'],
                                'iade_aksiyon' => $_POST['iade_aksiyon']
                            ));
                            if($sonuc){
                                $_SESSION['collepse_status'] = 'product_list';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                            }else{
                            echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Product Status SON */
            
            /* Note */
            if($_GET['status'] == 'note_delete'  ) {
                if( $_GET['no'] && $_GET['orderID']) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_GET['orderID'],
                    ));
                    if($siparis->rowCount()>'0' ) {

                        $silmeislem = $db->prepare("DELETE from operator_not WHERE id=:id");
                        $silmeislem2 = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislem2) {
                            $_SESSION['collepse_status'] = 'operatorNote';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['orderID'].'');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }


            if($_GET['status'] == 'note_add'  ) {
                if ($_POST && isset($_POST['noteAdd']) && $_POST['order_id'] ) {
                    if($_POST['order_note']  ) {
                        $kaydet = $db->prepare("INSERT INTO operator_not SET
                              tarih=:tarih,  
                              open=:open,
                              icerik=:icerik,
                              siparis_no=:siparis_no,
                              operator=:operator
                        ");
                        $sonuc = $kaydet->execute(array(
                            'tarih' => $timestamp,
                            'open' => $_POST['open_note'],
                            'icerik' => $_POST['order_note'],
                            'siparis_no' => $_POST['order_id'],
                            'operator' => $adminRow['isim'].' '.$adminRow['soyisim'],
                        ));
                        if($sonuc){
                            $_SESSION['collepse_status'] = 'operatorNote';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Note SON */
            
            /* Tek tek kargo */
            if($_GET['status'] == 'product_cargo_update'  ) {
                if($_POST && isset($_POST['kargoTip2']) && $_POST['order_id'] && $_POST['pro_id']  ) {

                    $guncelle = $db->prepare("UPDATE siparisler SET
                            kargo_sekli=:kargo_sekli
                     WHERE siparis_no={$_POST['order_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'kargo_sekli' => '1'
                    ));
                    
                    $producek = $db->prepare("select * from siparis_urunler where id=:id  ");
                    $producek->execute(array(
                        'id' => $_POST['pro_id'],
                    ));
                    $proRow = $producek->fetch(PDO::FETCH_ASSOC);

                    if($producek->rowCount()>'0'  ) {
                     $urunBaslik = $proRow['urun_baslik'];
                    }else{
                        $urunBaslik = null;
                    }
                    
                    if($sonuc){
                        $kargoSQL = $db->prepare("select * from siparis_kargo where siparis_urun_id=:siparis_urun_id ");
                        $kargoSQL->execute(array(
                            'siparis_urun_id' => $_POST['pro_id']
                        ));
                        if($kargoSQL->rowCount()>'0' ) {
                            /* Mevcut Bilgileri GÜncelle */
                            if($_POST['kargo_takip'] == !null  ) {
                                $kargoFirmaCek = $db->prepare("select * from kargo_firma where id=:id ");
                                $kargoFirmaCek->execute(array(
                                    'id' => $_POST['kargo_firma'],
                                ));
                                $kargoRows = $kargoFirmaCek->fetch(PDO::FETCH_ASSOC);

                                if($kargoFirmaCek->rowCount()>'0'  ) {
                                    $kargofirma = $kargoRows['baslik'];
                                }else{
                                    $kargofirma = $kargoRows['baslik'];
                                }
                                $kargotakip = $_POST['kargo_takip'];


                                /* SİTE İÇİ BİLDİRİM */
                                if($_POST['noti']=='1'  ) {
                                    if($notiSet['durum'] == '1' ) {
                                        $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                        $sips->execute(array(
                                            'siparis_no' => $_POST['order_id'],
                                        ));
                                        if($sips->rowCount()>'0'  ) {
                                            $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                            $user = $sipRow['uye_id'];
                                            $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                            $kullaniciCek->execute(array(
                                                'id' => $user
                                            ));
                                            if($kullaniciCek->rowCount()>'0'  ) {
                                                $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                                $rand = rand(0,(int) 9999999999);
                                                $baslik = $diller['adminpanel-bildirim-text-25'];
                                                $icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$_POST['order_id'].' '.$diller['adminpanel-bildirim-text-26'].' '.$urunBaslik.'  '.$diller['adminpanel-bildirim-text-27'].' <br><br> '.$diller['adminpanel-bildirim-text-21'].' <strong>'.$kargofirma.'</strong> <br> '.$diller['adminpanel-bildirim-text-22'].' <strong>'.$kargotakip.'</strong> ';
                                                /* Site içi bildirim gönder */
                                                $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                                    bildirim_id=:bildirim_id,
                                                                    baslik=:baslik,
                                                                    icerik=:icerik,
                                                                    tarih=:tarih,
                                                                    tur=:tur,
                                                                    ikon=:ikon,
                                                                    uye_id=:uye_id,
                                                                    durum=:durum,
                                                                    dil=:dil
                                                                    ");
                                                $sonuc = $kaydet->execute(array(
                                                    'bildirim_id' => $rand,
                                                    'baslik' => $baslik,
                                                    'icerik' => $icerik,
                                                    'tarih' => $timestamp,
                                                    'tur' => '2',
                                                    'ikon' => '&#128666;',
                                                    'uye_id' => $user,
                                                    'durum' => '1',
                                                    'dil' => $_SESSION['dil']
                                                ));
                                                /*  <========SON=========>>> Site içi bildirim gönder SON */

                                            }
                                        }
                                    }
                                }
                                /*  <========SON=========>>> SİTE İÇİ BİLDİRİM SON */

                                /* SMS */
                                if($_POST['sms_noti']=='1'  ) {
                                    if($sms['durum'] == '1' ) {
                                        $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                        $sips->execute(array(
                                            'siparis_no' => $_POST['order_id'],
                                        ));
                                        if($sips->rowCount()>'0'  ) {
                                            $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                            $isim = $sipRow['isim'];
                                            $soyisim = $sipRow['soyisim'];
                                            $numara = $sipRow['telefon'];
                                            $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$_POST['order_id'].' '.$diller['adminpanel-bildirim-text-26'].' '.$urunBaslik.' '.$diller['adminpanel-bildirim-text-27'].' '.$diller['adminpanel-bildirim-text-21'].' '.$kargofirma.' '.$diller['adminpanel-bildirim-text-22'].' '.$kargotakip.'';
                                            include 'inc/modules/orders/order_noti_sms.php';
                                        }
                                    }
                                }
                                /*  <========SON=========>>> SMS SON */

                                /* E-POSTA */
                                if($_POST['email_noti']=='1'  ) {
                                    if($ayar['smtp_durum'] == '1' ) {
                                        $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                        $sips->execute(array(
                                            'siparis_no' => $_POST['order_id'],
                                        ));
                                        if($sips->rowCount()>'0'  ) {
                                            $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                            $user = $sipRow['uye_id'];
                                            $eposta = $sipRow['eposta'];
                                            $isim = $sipRow['isim'];
                                            $soyisim = $sipRow['soyisim'];
                                            include 'inc/modules/orders/order_product_cargo_noti_email.php';
                                        }
                                    }
                                }
                                /*  <========SON=========>>> E-POSTA SON */
                            }
                            /*  <========SON=========>>> Mevcut Bilgileri GÜncelle SON */
                            $guncelle = $db->prepare("UPDATE siparis_kargo SET
                                kargo_firma=:kargo_firma,
                                kargo_takip=:kargo_takip
                         WHERE siparis_urun_id={$_POST['pro_id']}      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'kargo_firma' => $_POST['kargo_firma'],
                                'kargo_takip' => $_POST['kargo_takip'],
                            ));
                        }else{
                            $kaydet = $db->prepare("INSERT INTO siparis_kargo SET
                           siparis_urun_id=:siparis_urun_id,
                                    kargo_firma=:kargo_firma,
                                kargo_takip=:kargo_takip,
                                siparis_id=:siparis_id     
                            ");
                            $sonuc = $kaydet->execute(array(
                                'siparis_urun_id' => $_POST['pro_id'],
                                'kargo_firma' => $_POST['kargo_firma'],
                                'kargo_takip' => $_POST['kargo_takip'],
                                'siparis_id' => $_POST['order_id'],
                            ));
                        }

                        $_SESSION['collepse_status'] = 'kargoAcc';
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Tek tek kargo SON */

            if($_GET['status'] == 'cargo_settings'  ) {
                if($_POST && isset($_POST['kargoTip1']) && $_POST['order_id']  ) {

                    $guncelle = $db->prepare("UPDATE siparisler SET
                            kargo_firma=:kargo_firma,
                            kargo_takip=:kargo_takip,
                            kargo_sekli=:kargo_sekli
                     WHERE siparis_no={$_POST['order_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'kargo_firma' => $_POST['kargo_firma'],
                        'kargo_takip' => $_POST['kargo_takip'],
                        'kargo_sekli' => '0'
                    ));
                    if($sonuc){

                        if($_POST['kargo_takip'] == !null  ) {
                            $kargoFirmaCek = $db->prepare("select * from kargo_firma where id=:id ");
                            $kargoFirmaCek->execute(array(
                                'id' => $_POST['kargo_firma'],
                            ));
                            $kargoRows = $kargoFirmaCek->fetch(PDO::FETCH_ASSOC);

                            if($kargoFirmaCek->rowCount()>'0'  ) {
                                $kargofirma = $kargoRows['baslik'];
                            }else{
                                $kargofirma = $kargoRows['baslik'];
                            }
                            $kargotakip = $_POST['kargo_takip'];

                            /* SMS */
                            if($_POST['sms_noti']=='1'  ) {
                                if($sms['durum'] == '1' ) {
                                    $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                    $sips->execute(array(
                                        'siparis_no' => $_POST['order_id'],
                                    ));
                                    if($sips->rowCount()>'0'  ) {
                                        $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                        $isim = $sipRow['isim'];
                                        $soyisim = $sipRow['soyisim'];
                                        $numara = $sipRow['telefon'];
                                        $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$_POST['order_id'].' '.$diller['adminpanel-bildirim-text-20'].' '.$diller['adminpanel-bildirim-text-21'].' '.$kargofirma.' , '.$diller['adminpanel-bildirim-text-22'].' '.$kargotakip.' ';
                                        include 'inc/modules/orders/order_noti_sms.php';
                                    }
                                }
                            }
                            /*  <========SON=========>>> SMS SON */

                            /* E-POSTA */
                            if($_POST['email_noti']=='1'  ) {
                                if($ayar['smtp_durum'] == '1' ) {
                                    $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                    $sips->execute(array(
                                        'siparis_no' => $_POST['order_id'],
                                    ));
                                    if($sips->rowCount()>'0'  ) {
                                        $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                        $user = $sipRow['uye_id'];
                                        $eposta = $sipRow['eposta'];
                                        $isim = $sipRow['isim'];
                                        $soyisim = $sipRow['soyisim'];
                                        include 'inc/modules/orders/order_cargo_noti_email.php';
                                    }
                                }
                            }
                            /*  <========SON=========>>> E-POSTA SON */

                            /* SİTE İÇİ BİLDİRİM */
                            if($_POST['noti']=='1'  ) {
                                if($notiSet['durum'] == '1' ) {
                                    $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                    $sips->execute(array(
                                        'siparis_no' => $_POST['order_id'],
                                    ));
                                    if($sips->rowCount()>'0'  ) {
                                        $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                        $user = $sipRow['uye_id'];
                                        $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                        $kullaniciCek->execute(array(
                                            'id' => $user
                                        ));
                                        if($kullaniciCek->rowCount()>'0'  ) {
                                            $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                            $rand = rand(0,(int) 9999999999);
                                            $baslik = $diller['adminpanel-bildirim-text-23'];
                                            $icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$_POST['order_id'].' '.$diller['adminpanel-bildirim-text-20'].' <br><br> '.$diller['adminpanel-bildirim-text-21'].' <strong>'.$kargofirma.'</strong> <br> '.$diller['adminpanel-bildirim-text-22'].' <strong>'.$kargotakip.'</strong>';
                                            /* Site içi bildirim gönder */
                                            $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                    bildirim_id=:bildirim_id,
                                                    baslik=:baslik,
                                                    icerik=:icerik,
                                                    tarih=:tarih,
                                                    tur=:tur,
                                                    ikon=:ikon,
                                                    uye_id=:uye_id,
                                                    durum=:durum,
                                                    dil=:dil
                                                    ");
                                            $sonuc = $kaydet->execute(array(
                                                'bildirim_id' => $rand,
                                                'baslik' => $baslik,
                                                'icerik' => $icerik,
                                                'tarih' => $timestamp,
                                                'tur' => '2',
                                                'ikon' => '&#128666;',
                                                'uye_id' => $user,
                                                'durum' => '1',
                                                'dil' => $_SESSION['dil']
                                            ));
                                            /*  <========SON=========>>> Site içi bildirim gönder SON */

                                        }
                                    }
                                }
                            }
                            /*  <========SON=========>>> SİTE İÇİ BİLDİRİM SON */
                        }


                        $_SESSION['collepse_status'] = 'kargoAcc';
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            
            

            if($_GET['status'] == 'transfer_delete'  ) {
                if( $_GET['no']) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_GET['no'],
                    ));
                    if($siparis->rowCount()>'0' ) {

                        $silmeislem = $db->prepare("DELETE from odeme_bildirim WHERE siparis_no=:siparis_no");
                        $silmeislem2 = $silmeislem->execute(array(
                           'siparis_no' => $_GET['no']
                        ));
                        if ($silmeislem2) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['no'].'');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'transfer_no'  ) {
                if( $_GET['no']) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_GET['no'],
                    ));
                    if($siparis->rowCount()>'0' ) {

                        $guncelle = $db->prepare("UPDATE odeme_bildirim SET
                                    durum=:durum
                             WHERE siparis_no={$_GET['no']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'durum' => '2',
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['no'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'transfer_pasive'  ) {
                if( $_GET['no']) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_GET['no'],
                    ));
                    if($siparis->rowCount()>'0' ) {

                        $guncelle = $db->prepare("UPDATE odeme_bildirim SET
                                    durum=:durum
                             WHERE siparis_no={$_GET['no']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'durum' => '0',
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['no'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'transfer_confirm'  ) {
                if( $_GET['no']) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_GET['no'],
                    ));
                    if($siparis->rowCount()>'0' ) {

                        $guncelle = $db->prepare("UPDATE odeme_bildirim SET
                                    durum=:durum
                             WHERE siparis_no={$_GET['no']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'durum' => '1',
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['no'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'invoice_add'  ) {
                if ($_POST && $_POST['order_id'] && isset($_POST['insert'])) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_POST['order_id'],
                    ));
                    if($siparis->rowCount()>'0'  ) {
                        if ($_FILES['invoice']["size"] > 0) {
                            $file_format = $_FILES["invoice"];
                            $kaynak = $_FILES["invoice"]["tmp_name"];
                            $uzanti = explode(".", $_FILES['invoice']['name']);
                            $random = rand(0, (int)99999);
                            $random2 = rand(0, (int)999);
                            $orderID = $_POST['order_id'];
                            $filename = trim(addslashes($_FILES['invoice']['name']));
                            $filename = str_replace(' ', '_', $filename);
                            $filename = str_replace('ş', 's', $filename);
                            $filename = str_replace('&', '-', $filename);
                            $filename = str_replace('%', '-', $filename);
                            $filename = str_replace('?', '-', $filename);
                            $filename = str_replace('+', '-', $filename);
                            $filename = str_replace('ı', 'i', $filename);
                            $filename = str_replace('Ş', 's', $filename);
                            $filename = str_replace('ğ', 'g', $filename);
                            $filename = str_replace('Ğ', 'g', $filename);
                            $filename = str_replace('ü', 'u', $filename);
                            $filename = str_replace('Ü', 'u', $filename);
                            $filename = str_replace('ç', 'c', $filename);
                            $filename = str_replace('Ç', 'c', $filename);
                            $filename = str_replace('ö', 'o', $filename);
                            $filename = str_replace('Ö', 'o', $filename);
                            $filename = str_replace('İ', 'i', $filename);
                            $filename = preg_replace('/\s+/', '_', $filename);
                            $file_name = $random . "-" . $random2 . "-" .$orderID . "-". $filename;
                            $target = "../i/invoice/" . $file_name;

                            if ( $file_format['type'] == 'application/pdf'   ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $kaydet = $db->prepare("INSERT INTO siparis_fatura SET
                                                siparis_no=:siparis_no,
                                                fatura_url=:fatura_url
                                                ");
                                    $sonuc = $kaydet->execute(array(
                                        'siparis_no' => $_POST['order_id'],
                                        'fatura_url' => $file_name
                                    ));
                                    if($sonuc){
                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }

                            }else{
                                header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                                $_SESSION['main_alert'] = 'filetype';
                            }
                        }else{
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                            $_SESSION['main_alert'] = 'filesize';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=orders');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            /* Invoice Delete */
            if($_GET['status'] == 'invoice_delete'  ) {
                if ($_GET['no']) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_GET['no'],
                    ));
                    if($siparis->rowCount()>'0'  ) {
                        $fatura = $db->prepare("select * from siparis_fatura where siparis_no=:siparis_no ");
                        $fatura->execute(array(
                            'siparis_no' => $_GET['no'],
                        ));
                        if($fatura->rowCount()>'0' ) {
                            $f = $fatura->fetch(PDO::FETCH_ASSOC);
                            unlink('../i/invoice/'.$f['fatura_url'].'');
                            $silmeislem = $db->prepare("DELETE from siparis_fatura WHERE siparis_no=:siparis_no");
                            $silmeislem2 = $silmeislem->execute(array(
                               'siparis_no' => $_GET['no']
                            ));
                            if ($silmeislem2) {
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['no'].'');
                            }else {
                                echo 'veritabanı hatası';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=orders');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Invoice Delete SON */


            /* Talep Sil */
            if($_GET['status'] == 'cancel_request_delete'  ) {
                if ($_GET['no'] && $_GET['orderID']) {
                    $silmeislem = $db->prepare("DELETE from siparis_iptal WHERE talep_no=:talep_no");
                    $silmeislems = $silmeislem->execute(array(
                       'talep_no' => $_GET['no']
                    ));
                    if ($silmeislems) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['orderID'].'');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Talep Sil SON */

            /* İptal İşlemi */
            if($_GET['status'] == 'order_cancel'  ) {
                if( $_GET['no']) {
                        $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                        $siparis->execute(array(
                            'siparis_no' => $_GET['no'],
                        ));
                        if($siparis->rowCount()>'0' ) {

                            $guncelle = $db->prepare("UPDATE siparisler SET
                                    iptal=:iptal
                             WHERE siparis_no={$_GET['no']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'iptal' => '1',
                            ));
                            if($sonuc){
                                /* Talep varsa onunda durumunu 1 yap */
                                $talep = $db->prepare("select * from siparis_iptal where siparis_no=:siparis_no ");
                                $talep->execute(array(
                                    'siparis_no' => $_GET['no'],
                                ));
                                if($talep->rowCount()>'0'  ) {
                                 $guncelle = $db->prepare("UPDATE siparis_iptal SET
                                         durum=:durum,
                                         yeni=:yeni
                                  WHERE siparis_no={$_GET['no']}      
                                 ");
                                 $sonuc = $guncelle->execute(array(
                                     'durum' => '1',
                                     'yeni' => '0',
                                 ));
                                }
                                /*  <========SON=========>>> Talep varsa onunda durumunu 1 yap SON */
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['no'].'');
                            }else{
                            echo 'Veritabanı Hatası';
                            }
                        }else {
                            header('Location:'.$ayar['site_url'].'404');
                        }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> İptal İşlemi SON */

            /* Active İşlemi */
            if($_GET['status'] == 'order_active'  ) {
                if( $_GET['no']) {
                    $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                    $siparis->execute(array(
                        'siparis_no' => $_GET['no'],
                    ));
                    if($siparis->rowCount()>'0' ) {

                        $guncelle = $db->prepare("UPDATE siparisler SET
                                    iptal=:iptal
                             WHERE siparis_no={$_GET['no']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'iptal' => '0',
                        ));
                        if($sonuc){
                            /* Talep varsa onunda durumunu 1 yap */
                            $talep = $db->prepare("select * from siparis_iptal where siparis_no=:siparis_no ");
                            $talep->execute(array(
                                'siparis_no' => $_GET['no'],
                            ));
                            if($talep->rowCount()>'0'  ) {
                                $guncelle = $db->prepare("UPDATE siparis_iptal SET
                                         durum=:durum
                                  WHERE siparis_no={$_GET['no']}      
                                 ");
                                $sonuc = $guncelle->execute(array(
                                    'durum' => '0',
                                ));
                            }
                            /*  <========SON=========>>> Talep varsa onunda durumunu 1 yap SON */
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_GET['no'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else {
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Active İşlemi SON */


            if($_GET['status'] == 'change'  ) {
                if($_POST && isset($_POST['update']) && $_POST['order_id']  ) {
                    $guncelle = $db->prepare("UPDATE siparisler  SET
                      siparis_durum=:siparis_durum,
                      iptal_aksiyon=:iptal_aksiyon
                     WHERE siparis_no={$_POST['order_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'siparis_durum' => $_POST['siparis_durum'],
                        'iptal_aksiyon' => $_POST['iptal_aksiyon'],
                    ));
                    if($sonuc){
                        /* SMS */
                            if($_POST['sms_noti']=='1'  ) {
                                if($sms['durum'] == '1' ) {
                                    $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                    $sips->execute(array(
                                        'siparis_no' => $_POST['order_id'],
                                    ));
                                    if($sips->rowCount()>'0'  ) {
                                        $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                        $durum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                        $durum->execute(array(
                                            'id' => $sipRow['siparis_durum'],
                                        ));
                                        $d = $durum->fetch(PDO::FETCH_ASSOC);
                                        $isim = $sipRow['isim'];
                                        $soyisim = $sipRow['soyisim'];
                                        $durumbaslik = $d['baslik'];
                                            $numara = $sipRow['telefon'];
                                            $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$isim.' '.$soyisim.', #'.$_POST['order_id'].' '.$diller['adminpanel-bildirim-text-16'].' '.$durumbaslik.' '.$diller['adminpanel-bildirim-text-17'].'';
                                            include 'inc/modules/orders/order_noti_sms.php';
                                    }
                                }
                            }
                        /*  <========SON=========>>> SMS SON */
                        /* E-POSTA */
                            if($_POST['email_noti']=='1'  ) {
                                if($ayar['smtp_durum'] == '1' ) {
                                    $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                    $sips->execute(array(
                                        'siparis_no' => $_POST['order_id'],
                                    ));
                                    if($sips->rowCount()>'0'  ) {
                                        $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                        $durum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                        $durum->execute(array(
                                            'id' => $sipRow['siparis_durum'],
                                        ));
                                        $d = $durum->fetch(PDO::FETCH_ASSOC);
                                        $user = $sipRow['uye_id'];
                                            $eposta = $sipRow['eposta'];
                                            $isim = $sipRow['isim'];
                                            $soyisim = $sipRow['soyisim'];
                                            $durumbaslik = $d['baslik'];
                                            include 'inc/modules/orders/order_noti_email.php';
                                    }
                                }
                            }
                        /*  <========SON=========>>> E-POSTA SON */
                        /* SİTE İÇİ BİLDİRİM */
                        if($_POST['noti']=='1'  ) {
                            if($notiSet['durum'] == '1' ) {
                                $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                $sips->execute(array(
                                    'siparis_no' => $_POST['order_id'],
                                ));
                                if($sips->rowCount()>'0'  ) {
                                    $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                    $user = $sipRow['uye_id'];
                                    $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                    $kullaniciCek->execute(array(
                                        'id' => $user
                                    ));
                                    if($kullaniciCek->rowCount()>'0'  ) {
                                        $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                        $durum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                        $durum->execute(array(
                                            'id' => $sipRow['siparis_durum'],
                                        ));
                                        $d = $durum->fetch(PDO::FETCH_ASSOC);
                                        $rand = rand(0,(int) 9999999999);
                                        $baslik = $diller['adminpanel-bildirim-text-15'];
                                        $icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$_POST['order_id'].' '.$diller['adminpanel-bildirim-text-16'].' <strong>'.$d['baslik'].'</strong> '.$diller['adminpanel-bildirim-text-17'].'';
                                        /* Site içi bildirim gönder */
                                        $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                    bildirim_id=:bildirim_id,
                                                    baslik=:baslik,
                                                    icerik=:icerik,
                                                    tarih=:tarih,
                                                    tur=:tur,
                                                    ikon=:ikon,
                                                    uye_id=:uye_id,
                                                    durum=:durum,
                                                    dil=:dil
                                                    ");
                                        $sonuc = $kaydet->execute(array(
                                            'bildirim_id' => $rand,
                                            'baslik' => $baslik,
                                            'icerik' => $icerik,
                                            'tarih' => $timestamp,
                                            'tur' => '2',
                                            'ikon' => '&#128722',
                                            'uye_id' => $user,
                                            'durum' => '1',
                                            'dil' => $_SESSION['dil']
                                        ));
                                        /*  <========SON=========>>> Site içi bildirim gönder SON */

                                    }
                                }
                            }
                        }
                        /*  <========SON=========>>> SİTE İÇİ BİLDİRİM SON */
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'cancel_noti'  ) {
                if($_POST && isset($_POST['cancelNotifi']) && $_POST['order_id']  ) {
                        /* SMS */
                        if($_POST['sms_noti']=='1'  ) {
                            if($sms['durum'] == '1' ) {
                                $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                $sips->execute(array(
                                    'siparis_no' => $_POST['order_id'],
                                ));
                                if($sips->rowCount()>'0'  ) {
                                    $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                    $isim = $sipRow['isim'];
                                    $soyisim = $sipRow['soyisim'];
                                    $numara = $sipRow['telefon'];
                                    $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$sipRow['isim'].' '.$sipRow['soyisim'].',  #'.$_POST['order_id'].' '.$diller['adminpanel-bildirim-text-19'].'';
                                    include 'inc/modules/orders/order_noti_sms.php';
                                }
                            }
                        }
                        /*  <========SON=========>>> SMS SON */
                        /* E-POSTA */
                        if($_POST['email_noti']=='1'  ) {
                            if($ayar['smtp_durum'] == '1' ) {
                                $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                $sips->execute(array(
                                    'siparis_no' => $_POST['order_id'],
                                ));
                                if($sips->rowCount()>'0'  ) {
                                    $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                    $durum = $db->prepare("select * from siparis_durumlar where id=:id ");
                                    $durum->execute(array(
                                        'id' => $sipRow['siparis_durum'],
                                    ));
                                    $d = $durum->fetch(PDO::FETCH_ASSOC);
                                    $eposta = $sipRow['eposta'];
                                    $isim = $sipRow['isim'];
                                    $soyisim = $sipRow['soyisim'];
                                    include 'inc/modules/orders/order_cancel_noti_email.php';
                                }
                            }
                        }
                        /*  <========SON=========>>> E-POSTA SON */
                        /* SİTE İÇİ BİLDİRİM */
                        if($_POST['noti']=='1'  ) {
                            if($notiSet['durum'] == '1' ) {
                                $sips = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                                $sips->execute(array(
                                    'siparis_no' => $_POST['order_id'],
                                ));
                                if($sips->rowCount()>'0'  ) {
                                    $sipRow = $sips->fetch(PDO::FETCH_ASSOC);
                                    $user = $sipRow['uye_id'];
                                    $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                    $kullaniciCek->execute(array(
                                        'id' => $user
                                    ));
                                    if($kullaniciCek->rowCount()>'0'  ) {
                                        $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                        $rand = rand(0,(int) 9999999999);
                                        $baslik = $diller['adminpanel-bildirim-text-18'];
                                        $icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$_POST['order_id'].' '.$diller['adminpanel-bildirim-text-19'].'';
                                        /* Site içi bildirim gönder */
                                        $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                                    bildirim_id=:bildirim_id,
                                                    baslik=:baslik,
                                                    icerik=:icerik,
                                                    tarih=:tarih,
                                                    tur=:tur,
                                                    ikon=:ikon,
                                                    uye_id=:uye_id,
                                                    durum=:durum,
                                                    dil=:dil
                                                    ");
                                        $sonuc = $kaydet->execute(array(
                                            'bildirim_id' => $rand,
                                            'baslik' => $baslik,
                                            'icerik' => $icerik,
                                            'tarih' => $timestamp,
                                            'tur' => '2',
                                            'ikon' => '&#128683;',
                                            'uye_id' => $user,
                                            'durum' => '1',
                                            'dil' => $_SESSION['dil']
                                        ));
                                        /*  <========SON=========>>> Site içi bildirim gönder SON */

                                    }
                                }
                            }
                        }
                        /*  <========SON=========>>> SİTE İÇİ BİLDİRİM SON */
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_detail&orderID='.$_POST['order_id'].'');
                }else{
                    header('Location:'.$ayar['site_url'].'404');
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