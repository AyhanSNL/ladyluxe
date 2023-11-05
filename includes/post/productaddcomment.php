<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
if($_POST) {
    $KontrolName = trim(strip_tags($_POST['commentAdd']));
    if($KontrolName == '1'  ) {
        $yildiz = strip_tags(trim($_POST['star_rate']));
        $baslik = trim(strip_tags($_POST['baslik']));
        $isim= $userCek['isim'];
        $soyisim= $userCek['soyisim'];
        $eposta= $userCek['eposta'];
        $yorum = trim(strip_tags($_POST['yorum']));
        $tarih = $timestamp = date('Y-m-d G:i:s');
        $uye_id = $userCek['id'];
        $gizli = $_POST['gizli'];
        $rand_id= rand(0,(int) 99999999);
        $rand = rand(0,(int) 9999999999);

        $id = trim(strip_tags($_POST['pID']));
        $seo = trim(strip_tags($_POST['hash']));
        $urunAyarlari = $db->prepare("select urun_yorum_onay from urun_detay where id=:id ");
        $urunAyarlari->execute(array(
            'id' => '1'
        ));
        $urunAyar = $urunAyarlari->fetch(PDO::FETCH_ASSOC);
        if($urunAyar['urun_yorum_onay'] == '0' ) {
            $onayyazi = ''.$diller['oto-eposta-urunyorum-onaysiz'].'';
            $durumcek = '0';
        }
        if($urunAyar['urun_yorum_onay'] == '1' ) {
            $onayyazi = ''.$diller['oto-eposta-urunyorum-onayli'].'';
            $durumcek = '1';
        }
        $uruNMSorgu = $db->prepare("select seo_url,id,baslik from urun where id=:id ");
        $uruNMSorgu->execute(array(
            'id' => $id
        ));
        $urunRow = $uruNMSorgu->fetch(PDO::FETCH_ASSOC);
        if($demo != '1'  ){
        if($uruNMSorgu->rowCount()>'0'  ) {
            if (md5($urunRow['seo_url']) == $seo) {
                if($yildiz && $baslik && $yorum) {
                    if($gizli == '0' || $gizli == '1'  ) {
                        if($yildiz=='1' || $yildiz=='2' || $yildiz=='3' || $yildiz=='4' || $yildiz=='5') {
                            $kaydet = $db->prepare("INSERT INTO urun_yorum SET
                            uye_id=:uye_id,
                            yildiz=:yildiz,
                            urun_id=:urun_id,
                            gizli=:gizli,
                            onay=:onay,
                            tarih=:tarih,
                            baslik=:baslik,
                            isim=:isim,
                            rand_id=:rand_id,
                            soyisim=:soyisim,
                            yorum=:yorum
                    ");
                            $sonuc = $kaydet->execute(array(
                                'uye_id' => $uye_id,
                                'yildiz' => $yildiz,
                                'urun_id' => $id,
                                'gizli' => $gizli,
                                'onay' => $durumcek,
                                'tarih' => $tarih,
                                'baslik' => $baslik,
                                'isim' => $isim,
                                'rand_id' => $rand_id,
                                'soyisim' => $soyisim,
                                'yorum' => $yorum
                            ));
                            if($sonuc){
                                /* Panel bildirim */
                                $kaydet = $db->prepare("INSERT INTO panel_bildirim SET
                                    durum=:durum,
                                    tarih=:tarih,
                                    modul=:modul,
                                    icerik_id=:icerik_id
                                    ");
                                $sonuc = $kaydet->execute(array(
                                    'durum' => '1',
                                    'tarih' => $timestamp,
                                    'modul' => 'urunyorum',
                                    'icerik_id' => $rand
                                ));
                                /*  <========SON=========>>> Panel bildirim SON */

                                /* E-Posta Bildirimleri */
                                if($ayar['smtp_durum'] == '1' ) {
                                    include 'includes/post/mailtemp/urun_yorum_mail_temp.php';
                                }
                                /* E-Posta Bildirimleri SON */
                                $_SESSION['yorum_eklendi'] = 'success';
                                header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            $_SESSION['yorum_eklendi'] = 'starproblem';
                            header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                        }
                    }else{
                        header('Location:'.$siteurl.'404');
                    }
                }else{
                    $_SESSION['yorum_eklendi'] = 'empty';
                    header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
                }
            }else{
                header('Location:'.$siteurl.'404');
            }
        }else{
            header('Location:'.$siteurl.'404');
        }
        }else{
            $_SESSION['demo_alert'] = 'demo';
            header('Location:'.$siteurl.''.$urunRow['seo_url'].'-P'.$urunRow['id'].'');
        }
    } else {
        header('Location:'.$siteurl.'404');
    }
}else{
    header('Location:'.$siteurl.'404');
}
?>