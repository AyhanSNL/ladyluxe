<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
//todo ioncube
include 'includes/func/cartcalc.php';
$ipcek = $_SERVER["REMOTE_ADDR"];
$sepetteUrun = $db->prepare("select * from sepet where ip=:ip  ");
$sepetteUrun->execute(array(
    'ip' => $ipcek,
));

$aktifSepet = $db->prepare("select * from sepet where ip=:ip and sepet_durum=:sepet_durum  ");
$aktifSepet->execute(array(
    'ip' => $ipcek,
    'sepet_durum' => '1'
));

if($demo != '1'  ) {

/////////////////////////* İndirim Kuponu kodları  ///////////////////////////////////////////*/
if($_POST) {

    if(isset($_POST['discountValue'])) {



        $todayDate = date('Y-m-d');

        if($odemeayar['sepet_kupon'] =='1' && $aktifSepet->rowCount()>'0' && $uyeayar['durum'] == '1'  ) {
            if($userSorgusu->rowCount()>'0' ) {

                $kuponkodu = trim(strip_tags($_POST['discount']));

                $kuponSorgu = $db->prepare("select * from kupon where kod=:kod ");
                $kuponSorgu->execute(array(
                    'kod' => $kuponkodu
                ));
                $kuponCek = $kuponSorgu->fetch(PDO::FETCH_ASSOC);

                if($kuponSorgu->rowCount()>'0' && $kuponCek['durum'] == '1'  ) {

                    if($kuponCek['adet'] > '0' ) {

                        if($todayDate >= $kuponCek['baslangic']) {
                            if($todayDate <= $kuponCek['bitis']) {
                                if( $aratoplam+$kdvtoplami >= $kuponCek['sepe_alt_limit']) {
                                    if($kuponCek['uye_id']=='0' || $kuponCek['uye_id']== null  ) {

                                        $sepetKuponSorgu = $db->prepare("select * from sepet_kupon where kupon_id=:kupon_id and uye_id=:uye_id and durum=:durum ");
                                        $sepetKuponSorgu->execute(array(
                                            'kupon_id' => $kuponCek['id'],
                                            'uye_id' => $userCek['id'],
                                            'durum' => '1'
                                        ));

                                        if($sepetKuponSorgu->rowCount()>'0'  ) {

                                            /* Bu üye bu kuponu kullanmış. UYARI VER */
                                            $_SESSION['sepet_modal'] = 'kullanilmis';
                                            header('Location:'.$siteurl.'sepet/');
                                            exit();
                                            /* Bu üye bu kuponu kullanmış. UYARI VER SON */

                                        }else{



                                            /* Daha önce kupon kullanılmmaış. KUPONU EKLE VE TANIMLA */
                                            $kaydet = $db->prepare("INSERT INTO sepet_kupon SET
                                                                kupon_id=:kupon_id,
                                                                ip=:ip,
                                                                random_id=:random_id,
                                                                uye_id=:uye_id,
                                                                kullanim=:kullanim,
                                                                durum=:durum
                                                        ");
                                            $sonuc = $kaydet->execute(array(
                                                'kupon_id' => $kuponCek['id'],
                                                'ip' => $ipcek,
                                                'random_id' => $kuponCek['random'],
                                                'uye_id' => $userCek['id'],
                                                'kullanim' => '0',
                                                'durum' => '1'
                                            ));
                                            if($sonuc){
                                                /* İndirim kuponunun adetini düşür */
                                                $guncelle = $db->prepare("UPDATE kupon SET
                                                    adet=:adet 
                                              WHERE id={$kuponCek['id']}      
                                             ");
                                                $sonuc = $guncelle->execute(array(
                                                    'adet' => $kuponCek['adet']-1
                                                ));
                                                /* İndirim kuponunun adetini düşür SON */
                                                $_SESSION['sepet_modal'] = 'success';
                                                header('Location:'.$siteurl.'sepet/');
                                            }else{
                                                $_SESSION['dberror'] = 'dberror';
                                                header('Location:index.html');
                                                exit();
                                            }
                                            /* Daha önce kupon kullanılmmaış. KUPONU EKLE VE TANIMLA SON */



                                        }
                                    }else{
                                        if($userCek['id'] == $kuponCek['uye_id']) {

                                            $sepetKuponSorgu = $db->prepare("select * from sepet_kupon where kupon_id=:kupon_id and uye_id=:uye_id and durum=:durum ");
                                            $sepetKuponSorgu->execute(array(
                                                'kupon_id' => $kuponCek['id'],
                                                'uye_id' => $userCek['id'],
                                                'durum' => '1'
                                            ));

                                            if($sepetKuponSorgu->rowCount()>'0'  ) {

                                                /* Bu üye bu kuponu kullanmış. UYARI VER */
                                                $_SESSION['sepet_modal'] = 'kullanilmis';
                                                header('Location:'.$siteurl.'sepet/');
                                                /* Bu üye bu kuponu kullanmış. UYARI VER SON */

                                            }else{

                                                /* Daha önce kupon kullanılmmaış. KUPONU EKLE VE TANIMLA */
                                                $kaydet = $db->prepare("INSERT INTO sepet_kupon SET
                                                                kupon_id=:kupon_id,
                                                                ip=:ip,
                                                                random_id=:random_id,
                                                                uye_id=:uye_id,
                                                                kullanim=:kullanim,
                                                                durum=:durum
                                                        ");
                                                $sonuc = $kaydet->execute(array(
                                                    'kupon_id' => $kuponCek['id'],
                                                    'ip' => $ipcek,
                                                    'random_id' => $kuponCek['random'],
                                                    'uye_id' => $userCek['id'],
                                                    'kullanim' => '0',
                                                    'durum' => '1'
                                                ));
                                                if($sonuc){
                                                    $_SESSION['sepet_modal'] = 'success';
                                                    header('Location:'.$siteurl.'sepet/');
                                                }else{
                                                    $_SESSION['dberror'] = 'dberror';
                                                    header('Location:index.html');
                                                }
                                                /* Daha önce kupon kullanılmmaış. KUPONU EKLE VE TANIMLA SON */

                                                /* İndirim kuponunun adetini düşür */
                                                $guncelle = $db->prepare("UPDATE kupon SET
                                                    adet=:adet 
                                                      WHERE id={$kuponCek['id']}      
                                                     ");
                                                $sonuc = $guncelle->execute(array(
                                                    'adet' => $kuponCek['adet']-1
                                                ));
                                                /* İndirim kuponunun adetini düşür SON */

                                            }


                                        }else{
                                            $_SESSION['sepet_modal'] = 'baskauye';
                                            header('Location:'.$siteurl.'sepet/');
                                        }
                                    }
                                }else{
                                    $_SESSION['sepet_modal'] = 'sepetsorun';
                                    header('Location:'.$siteurl.'sepet/');
                                }
                            }else{
                                $_SESSION['sepet_modal'] = 'bitissorun';
                                header('Location:'.$siteurl.'sepet/');
                            }
                        }else{
                            $_SESSION['sepet_modal'] = 'baslangicsorun';
                            header('Location:'.$siteurl.'sepet/');
                        }
                    }else{
                        $_SESSION['sepet_modal'] = 'adetsizkupon';
                        header('Location:'.$siteurl.'sepet/');
                    }
                }else{
                    $_SESSION['sepet_modal'] = 'nokupon';
                    header('Location:'.$siteurl.'sepet/');
                }
            }else{
                $_SESSION['sepet_modal'] = 'nologin';
                header('Location:'.$siteurl.'sepet/');
            }
        }else{
            $_SESSION['sepet_modal'] = 'error';
            header('Location:'.$siteurl.'sepet/');
        }
    }else{
        header('Location:'.$siteurl.'sepet/');
    }

}else{
    header('Location:'.$siteurl.'sepet/');
    exit();
}
}else{
    $_SESSION['demo_alert'] = 'demo';
    header('Location:'.$siteurl.'sepet/');
}
/////////////////////////* İndirim Kuponu kodları  SON ///////////////////////////////////////////*/
///
///
///