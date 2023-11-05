<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
ob_start();
session_start();
date_default_timezone_set( 'Europe/Istanbul' );
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
$siteurl = $ayar['site_url'];
$site_adi = $ayar['site_baslik'];
$commentSettings = $db->prepare("select * from modul_yorum_ayar where id=:id ");
$commentSettings->execute(array(
    'id' => '1'
));
$comset = $commentSettings->fetch(PDO::FETCH_ASSOC);
?>
<?php
if (isset($_POST['add']) && $_POST) {
    $isim = trim(strip_tags($_POST['isim']));
    $eposta = trim(strip_tags($_POST['eposta']));
    $yorum = trim(strip_tags($_POST['yorum']));

    $id = trim(strip_tags($_POST['hID']));
    $seo = trim(strip_tags($_POST['hash']));

    $hizmetSorgu = $db->prepare("select * from hizmet where id=:id ");
    $hizmetSorgu->execute(array(
        'id' => $id
    ));
    $hizmetRow = $hizmetSorgu->fetch(PDO::FETCH_ASSOC);
    if($demo != '1'  ){
        if($hizmetSorgu->rowCount()>'0'  ) {
            if (md5($hizmetRow['seo_url']) == $seo) {
                if (filter_var($eposta, FILTER_VALIDATE_EMAIL)){
                    if($isim && $yorum && $eposta) {
                        $timestamp = date('Y-m-d G:i:s');
                        $modul = 'hizmet';
                        $yorum_tip = ''.$diller['modul-yorum-hizmetyorum'].'';
                        if($comset['oto_onay'] == '1'  ) {
                            $onaydurum = '1';
                            $onayyazi = ''.$diller['modul-yorum-onaylandi'].'';
                        }
                        if($comset['oto_onay'] == '0'  ) {
                            $onaydurum = '0';
                            $onayyazi = ''.$diller['modul-yorum-onaysiz'].'';
                        }

                        if($ayar['site_captcha'] == '1') {
                            if ($_POST['secure_code'] == $_SESSION['secure_code']) {
                                if($isim && $yorum && $eposta) {
                                    $kaydet = $db->prepare("INSERT INTO modul_yorum SET
                            isim=:isim,
                            eposta=:eposta,
                            icerik=:icerik,
                            tarih=:tarih,    
                            icerik_id=:icerik_id,
                            modul=:modul,
                            durum=:durum
                            ");
                                    $sonuc = $kaydet->execute(array(
                                        'isim' => $isim,
                                        'eposta' => $eposta,
                                        'icerik' => $yorum,
                                        'tarih' => $timestamp,
                                        'icerik_id' => $id,
                                        'modul' => $modul,
                                        'durum' => $onaydurum
                                    ));
                                    if($sonuc){
                                        $_SESSION['yorum_alert'] = 'success';
                                        header('Location:'.$siteurl.'hizmet/'.$hizmetRow['seo_url'].'/');
                                        /* E-Posta Bildirimleri */
                                        if($ayar['smtp_durum'] == '1' ) {
                                            include 'includes/post/mailtemp/hizmet_yorum_mail_temp.php';
                                        }
                                        /* E-Posta Bildirimleri SON */
                                        unset($_SESSION['secure_code']);
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    $_SESSION['yorum_alert'] = 'bos';
                                    header('Location:'.$siteurl.'hizmet/'.$hizmetRow['seo_url'].'/');
                                    unset($_SESSION['secure_code']);
                                }
                            }else{
                                $_SESSION['yorum_alert'] = 'secure';
                                header('Location:'.$siteurl.'hizmet/'.$hizmetRow['seo_url'].'/');
                                unset($_SESSION['secure_code']);
                            }
                        }

                        if($ayar['site_captcha'] == '0') {
                            if($isim && $yorum && $eposta) {
                                $kaydet = $db->prepare("INSERT INTO modul_yorum SET
                    isim=:isim,
                    eposta=:eposta,
                    icerik=:icerik,
                    tarih=:tarih,    
                    icerik_id=:icerik_id,
                    modul=:modul,
                    durum=:durum
                ");
                                $sonuc = $kaydet->execute(array(
                                    'isim' => $isim,
                                    'eposta' => $eposta,
                                    'icerik' => $yorum,
                                    'tarih' => $timestamp,
                                    'icerik_id' => $id,
                                    'modul' => $modul,
                                    'durum' => $onaydurum
                                ));
                                if($sonuc){
                                    $_SESSION['yorum_alert'] = 'success';
                                    header('Location:'.$siteurl.'hizmet/'.$hizmetRow['seo_url'].'/');
                                    /* E-Posta Bildirimleri */
                                    if($ayar['smtp_durum'] == '1' ) {
                                        include 'includes/post/mailtemp/hizmet_yorum_mail_temp.php';
                                    }
                                    /* E-Posta Bildirimleri SON */
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                $_SESSION['yorum_alert'] = 'bos';
                                header('Location:'.$siteurl.'hizmet/'.$hizmetRow['seo_url'].'/');
                            }
                        }
                    }else{
                        $_SESSION['yorum_alert'] = 'bos';
                        header('Location:'.$siteurl.'hizmet/'.$hizmetRow['seo_url'].'/');
                    }
                }else{
                    $_SESSION['yorum_alert'] = 'eposta';
                    header('Location:'.$siteurl.'hizmet/'.$hizmetRow['seo_url'].'/');
                }
            }else{
                header('Location:'.$siteurl.'404');
            }
        }else{
            header('Location:'.$siteurl.'404');
        }
    }else{
        $_SESSION['demo_alert'] = 'demo';
        header('Location:'.$siteurl.'hizmet/'.$hizmetRow['seo_url'].'/');
    }
}else{
    header('Location:'.$siteurl.'404');
}
?>