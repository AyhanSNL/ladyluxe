<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'multidelete' || $_GET['status'] == 'edit' ||  $_GET['status'] == 'delete' ||  $_GET['status'] == 'noti'  ||  $_GET['status'] == 'sms' ||  $_GET['status'] == 'email' ||  $_GET['status'] == 'first_order_update' ||  $_GET['status'] == 'first_order_delete' ||  $_GET['status'] == 'cart_discount') {

            $timestamp = date('Y-m-d G:i:s');

            /* sepette ek indirim */
            if($_GET['status'] == 'cart_discount'  ) {
                if ($_POST && isset($_POST['update'])) {

                    if($_POST['tur']=='1'  ) {
                        $tur = $_POST['tur'];
                        if($_POST['oran_oran'] == !null  ) {
                            $indirim = $_POST['oran_oran'];
                        }else{
                            $indirim = '0';
                        }
                    }else{
                        $tur = $_POST['tur'];
                        if($_POST['tutar_tutar'] == !null  ) {
                            $indirim = $_POST['tutar_tutar'];
                        }else{
                            $indirim = '0';
                        }
                    }

                    if($_POST['sepet_alt_limit'] == !null  ) {
                     $altlimit = $_POST['sepet_alt_limit'];
                    }else{
                        $altlimit = '0';
                    }

                    /* Update Kodları */
                    $guncelle = $db->prepare("UPDATE indirim_ek_sepet SET
                         durum=:durum,   
                         tur=:tur,
                         tutar=:tutar,
                         sepet_alt_limit=:sepet_alt_limit,
                         indirim_tip=:indirim_tip
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $_POST['durum'],
                        'tur' => $tur,
                        'tutar' => $indirim,
                        'sepet_alt_limit' => $altlimit,
                        'indirim_tip' => $_POST['indirim_tip']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=cart_discount');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> sepette ek indirim SON */
            
            
            /* İlk sipariş sil */
            if($_GET['status'] == 'first_order_delete'  ) {
                if($_GET['no'] == !null && isset($_GET['no'])  ) {
                    $sorgulabuislemi = $db->prepare("select * from indirim_ilk_siparis_kayit where id=:id ");
                    $sorgulabuislemi->execute(array(
                        'id' => $_GET['no']
                    ));
                    if($sorgulabuislemi->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from indirim_ilk_siparis_kayit WHERE id=:id");
                        $sil = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($sil) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=first_order_user');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> İlk sipariş sil SON */
            /* İlk Sipariş */
            if($_GET['status'] == 'first_order_update'  ) {
                if ($_POST && isset($_POST['update'])) {

                    if($_POST['tur']=='1'  ) {
                        $tur = $_POST['tur'];
                        if($_POST['oran_oran'] == !null  ) {
                            $indirim = $_POST['oran_oran'];
                        }else{
                            $indirim = '0';
                        }
                    }else{
                        $tur = $_POST['tur'];
                        if($_POST['tutar_tutar'] == !null  ) {
                            $indirim = $_POST['tutar_tutar'];
                        }else{
                            $indirim = '0';
                        }
                    }

                    if($_POST['sepet_alt_limit'] == !null  ) {
                        $altlimit = $_POST['sepet_alt_limit'];
                    }else{
                        $altlimit = '0';
                    }


                    /* Update Kodları */
                    $guncelle = $db->prepare("UPDATE indirim_ilk_siparis SET
                         durum=:durum,   
                         tur=:tur,
                         tutar=:tutar,
                         sepet_alt_limit=:sepet_alt_limit
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $_POST['durum'],
                        'tur' => $tur,
                        'tutar' => $indirim,
                        'sepet_alt_limit' => $altlimit
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=first_order_discount');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> İlk Sipariş SON */

            /* Noti */
            if($_GET['status'] == 'noti' && isset($_GET['couponID']) && isset($_GET['userID'])    ) {
                if ($_GET['couponID'] == !null && $_GET['userID'] == !null) {
                    $kuponID = $_GET['couponID'];
                    $user = $_GET['userID'];
                    $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                    $kullaniciCek->execute(array(
                        'id' => $user
                    ));
                    if($kullaniciCek->rowCount()>'0'  ) {
                        $kuponDetay = $db->prepare("select * from kupon where id=:id and uye_id=:uye_id ");
                        $kuponDetay->execute(array(
                            'id' => $kuponID,
                            'uye_id' => $user
                        ));
                        if($kuponDetay->rowCount()>'0'  ) {
                            $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                            $kuponRow = $kuponDetay->fetch(PDO::FETCH_ASSOC);

                            $rand = rand(0,(int) 9999999999);
                            $baslik = $diller['adminpanel-bildirim-text-1'];
                            $icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> '.$diller['adminpanel-bildirim-text-3'].'<br><br>'.$diller['adminpanel-bildirim-text-4'].' : <strong>'.$kuponRow['baslik'].'</strong>';

                            /* Site içi bildirim gönder */
                            $kaydet = $db->prepare("INSERT INTO bildirimler SET
                            bildirim_id=:bildirim_id,
                            baslik=:baslik,
                            icerik=:icerik,
                            tarih=:tarih,
                            tur=:tur,
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
                                'uye_id' => $user,
                                'durum' => '1',
                                'dil' => $_SESSION['dil']
                            ));
                            if($sonuc){
                                $guncelle = $db->prepare("UPDATE kupon  SET
                                     noti_durum=:noti_durum   
                                 WHERE id={$kuponID}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'noti_durum' => '1'
                                ));
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                            }else{
                            echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Site içi bildirim gönder SON */
                            
                            
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
            /*  <========SON=========>>> Noti SON */

            /* SMS  */
            if($_GET['status'] == 'sms' && isset($_GET['couponID']) && isset($_GET['userID'])    ) {
                if ($_GET['couponID'] == !null && $_GET['userID'] == !null) {
                  if($sms['durum'] == '1' ) {
                      $kuponID = $_GET['couponID'];
                      $user = $_GET['userID'];
                      $kuponDetayMailFor = $db->prepare("select * from kupon where id=:id and uye_id=:uye_id ");
                      $kuponDetayMailFor->execute(array(
                          'id' => $kuponID,
                          'uye_id' => $user
                      ));
                      $kup = $kuponDetayMailFor->fetch(PDO::FETCH_ASSOC);
                      if($kup['sms_durum'] !='1' ) {
                          $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                          $kullaniciCek->execute(array(
                              'id' => $user
                          ));
                          if($kullaniciCek->rowCount()>'0'  ) {
                              $kuponDetay = $db->prepare("select * from kupon where id=:id and uye_id=:uye_id ");
                              $kuponDetay->execute(array(
                                  'id' => $kuponID,
                                  'uye_id' => $user
                              ));
                              if($kuponDetay->rowCount()>'0'  ) {
                                  $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                  $kuponRow = $kuponDetay->fetch(PDO::FETCH_ASSOC);

                                  $numara = $userRow['telefon'];
                                  $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', '.$diller['adminpanel-bildirim-text-3'].' '.$diller['adminpanel-bildirim-text-4'].' : '.$kuponRow['baslik'].'';
                                  include 'inc/modules/campaign/coupon_sms_post.php';
                                  $guncelle = $db->prepare("UPDATE kupon  SET
                                     sms_durum=:sms_durum   
                                 WHERE id={$kuponID}      
                                ");
                                  $sonuc = $guncelle->execute(array(
                                      'sms_durum' => '1'
                                  ));
                                  $_SESSION['main_alert'] = 'success';
                                  header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');

                              }else{
                                  header('Location:'.$ayar['site_url'].'404');
                              }
                          }else{
                              header('Location:'.$ayar['site_url'].'404');
                          }
                      }else{
                          if(!isset($_GET['type']) ) {
                              $_SESSION['main_alert'] = 'smszaten';
                              $_SESSION['smszaten'] = 'kupon';
                              $_SESSION['smszatenurl'] = 'post.php?process=coupon_post&status=sms&userID='.$user.'&couponID='.$kuponID.'&type=again';
                              header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                          }else{
                              if($_GET['type']=='again'  ) {
                                  $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                  $kullaniciCek->execute(array(
                                      'id' => $user
                                  ));
                                  if($kullaniciCek->rowCount()>'0'  ) {
                                      $kuponDetay = $db->prepare("select * from kupon where id=:id and uye_id=:uye_id ");
                                      $kuponDetay->execute(array(
                                          'id' => $kuponID,
                                          'uye_id' => $user
                                      ));
                                      if($kuponDetay->rowCount()>'0'  ) {
                                          $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                          $kuponRow = $kuponDetay->fetch(PDO::FETCH_ASSOC);

                                          $numara = $userRow['telefon'];
                                          $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', '.$diller['adminpanel-bildirim-text-3'].' '.$diller['adminpanel-bildirim-text-4'].' : '.$kuponRow['baslik'].'';
                                          include 'inc/modules/campaign/coupon_sms_post.php';
                                          $guncelle = $db->prepare("UPDATE kupon  SET
                                     sms_durum=:sms_durum   
                                 WHERE id={$kuponID}      
                                ");
                                          $sonuc = $guncelle->execute(array(
                                              'sms_durum' => '1'
                                          ));
                                          $_SESSION['main_alert'] = 'success';
                                          header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');

                                      }else{
                                          header('Location:'.$ayar['site_url'].'404');
                                      }
                                  }else{
                                      header('Location:'.$ayar['site_url'].'404');
                                  }
                              }
                          }
                      }
                  }else{
                      $_SESSION['main_alert'] = 'smsoff';
                      header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                  }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> SMS  SON */

            /* Email */
            if($_GET['status'] == 'email' && isset($_GET['couponID']) && isset($_GET['userID'])    ) {
                if ($_GET['couponID'] == !null && $_GET['userID'] == !null) {
                    if($ayar['smtp_durum'] == '1' ) {
                        $kuponID = $_GET['couponID'];
                        $user = $_GET['userID'];
                        $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                        $kullaniciCek->execute(array(
                            'id' => $user
                        ));
                        if($kullaniciCek->rowCount()>'0'  ) {
                            $kuponDetay = $db->prepare("select * from kupon where id=:id and uye_id=:uye_id ");
                            $kuponDetay->execute(array(
                                'id' => $kuponID,
                                'uye_id' => $user
                            ));
                            if($kuponDetay->rowCount()>'0'  ) {
                                $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                $kuponRow = $kuponDetay->fetch(PDO::FETCH_ASSOC);
                                $eposta = $userRow['eposta'];
                                $isim = $userRow['isim'];
                                $soyisim = $userRow['soyisim'];
                                $kuponAdi = $kuponRow['baslik'];
                                $guncelle = $db->prepare("UPDATE kupon  SET
                                     eposta_durum=:eposta_durum   
                                 WHERE id={$kuponID}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'eposta_durum' => '1'
                                ));
                                include 'inc/modules/campaign/coupon_email_post.php';
                            }else{
                                header('Location:'.$ayar['site_url'].'404');
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'smtpoff';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Email SON */


            /*  Add */
            if($_GET['status'] == 'add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['baslik'] && $_POST['kod'] && $_POST['tur'] && $_POST['baslangic'] && $_POST['bitis'] && $_POST['adet'])  {

                        $random = rand(0,(int) 99999999);

                        if($_POST['tur']=='1'  ) {
                            $tur = $_POST['tur'];
                            if($_POST['oran_oran'] == !null  ) {
                                $indirim = $_POST['oran_oran'];
                            }else{
                                $indirim = '0';
                            }
                        }else{
                            $tur = $_POST['tur'];
                            if($_POST['tutar_tutar'] == !null  ) {
                                $indirim = $_POST['tutar_tutar'];
                            }else{
                                $indirim = '0';
                            }
                        }

                        if($_POST['sepe_alt_limit'] == !null  ) {
                            $altlimit = $_POST['sepe_alt_limit'];
                        }else{
                            $altlimit = '0';
                        }
                        
                        if($_POST['user_sec']==!null && $_POST['user_sec'] >'0' ) { 
                         $uye = $_POST['user_sec'];
                        }else{
                            $uye = null;
                        }
                        
                        $kaydet = $db->prepare("INSERT INTO kupon SET
                             durum=:durum,   
                             baslik=:baslik,
                             uye_id=:uye_id,
                             tur=:tur,
                             indirim_tutar=:indirim_tutar,
                             kod=:kod,
                             sepe_alt_limit=:sepe_alt_limit,
                             baslangic=:baslangic,
                             bitis=:bitis,
                             adet=:adet,
                             random=:random
                        ");
                        $sonuc = $kaydet->execute(array(
                            'durum' => $_POST['durum'],
                            'baslik' => $_POST['baslik'],
                            'uye_id' => $uye,
                            'tur' => $tur,
                            'indirim_tutar' => $indirim,
                            'kod' => $_POST['kod'],
                            'sepe_alt_limit' => $altlimit,
                            'baslangic' => $_POST['baslangic'],
                            'bitis' => $_POST['bitis'],
                            'adet' => $_POST['adet'],
                            'random' => $random
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  Edit */
            if($_GET['status'] == 'edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_POST['baslik'] && $_POST['kod2'] && $_POST['tur'] && $_POST['baslangic'] && $_POST['bitis'])  {

                        if($_POST['tur']=='1'  ) {
                            $tur = $_POST['tur'];
                            if($_POST['oran_oran'] == !null  ) {
                                $indirim = $_POST['oran_oran'];
                            }else{
                                $indirim = '0';
                            }
                        }else{
                            $tur = $_POST['tur'];
                            if($_POST['tutar_tutar'] == !null  ) {
                                $indirim = $_POST['tutar_tutar'];
                            }else{
                                $indirim = '0';
                            }
                        }

                        if($_POST['sepe_alt_limit'] == !null  ) {
                            $altlimit = $_POST['sepe_alt_limit'];
                        }else{
                            $altlimit = '0';
                        }

                        if($_POST['user_durum'] == '1'  ) {
                         /* Üyeye özelmiş */
                            if($_POST['herkes'] == '1'  ) {
                                $uye = null;
                            }else{
                                if($_POST['user_sec']==!null && $_POST['user_sec'] >'0' ) {
                                    $uye = $_POST['user_sec'];
                                }else{
                                    $uye = $_POST['user_id_hidden'];
                                }
                            }
                         /*  <========SON=========>>> Üyeye özelmiş SON */
                        }else{
                           /* Herkese açıkmışş */
                            if($_POST['user_sec']==!null && $_POST['user_sec'] >'0' ) {
                                $uye = $_POST['user_sec'];
                            }else{
                                $uye = null;
                            }
                            /*  <========SON=========>>> Herkese açıkmışş SON */
                        }

                        $guncelle = $db->prepare("UPDATE kupon SET
                                   durum=:durum,   
                             baslik=:baslik,
                             uye_id=:uye_id,
                             tur=:tur,
                             indirim_tutar=:indirim_tutar,
                             kod=:kod,
                             sepe_alt_limit=:sepe_alt_limit,
                             baslangic=:baslangic,
                             bitis=:bitis,
                             adet=:adet   
                         WHERE id={$_POST['coupon_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'durum' => $_POST['durum'],
                            'baslik' => $_POST['baslik'],
                            'uye_id' => $uye,
                            'tur' => $tur,
                            'indirim_tutar' => $indirim,
                            'kod' => $_POST['kod2'],
                            'sepe_alt_limit' => $altlimit,
                            'baslangic' => $_POST['baslangic'],
                            'bitis' => $_POST['bitis'],
                            'adet' => $_POST['adet']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /*  delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from kupon where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                        unlink('../images/uploads/'.$resim['gorsel'].'');
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from kupon WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */
            

            /*  <========SON=========>>> IMG Delete SON */

            /* Multi Delete */
            if($_GET['status'] == 'multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from kupon where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from kupon WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=coupons');
                }
            }
            /*  <========SON=========>>> Multi Delete SON */

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