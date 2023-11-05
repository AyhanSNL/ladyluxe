<?php
if($_POST && $userSorgusu->rowCount()>'0'){

    $destekno = trim(strip_tags($_POST['destek_no']));
    $hash = trim(strip_tags($_POST['hashNo']));
    $mesaj = trim(strip_tags($_POST['mesaj']));

    $destekCek = $db->prepare("select * from destek_talebi where destek_no=:destek_no and uye_id=:uye_id ");
    $destekCek->execute(array(
        'destek_no' => $destekno,
        'uye_id' => $userCek['id']
    ));
    $destekRow = $destekCek->fetch(PDO::FETCH_ASSOC);
    $baslik = $destekRow['baslik'];
    $eposta = $userCek['eposta'];
    $isim = $userCek['isim'];
    $soyisim = $userCek['soyisim'];
    if($demo != '1'  ){
        if($destekCek->rowCount()>'0') {
            if(md5($userCek['id']+$destekno) == $hash  ) {
                if($mesaj) {

                    $timestamp = date('Y-m-d G:i:s');
                    $kaydet = $db->prepare("INSERT INTO destek_talep_mesaj SET
              mesaj=:mesaj,
              tarih=:tarih,       
              gonderen=:gonderen,
              destek_no=:destek_no
             ");
                    $sonuc = $kaydet->execute(array(
                        'mesaj' => $mesaj,
                        'tarih' => $timestamp,
                        'gonderen' => '1',
                        'destek_no' => $destekno
                    ));
                    if($sonuc){
                        $guncelle = $db->prepare("UPDATE destek_talebi SET
                         son_islem=:son_islem,
                         durum=:durum
                  WHERE destek_no={$destekno}      
                 ");
                        $sonuc = $guncelle->execute(array(
                            'son_islem' => $timestamp,
                            'durum' => '0'
                        ));
                        if($sonuc){
                            /* E-Posta Bildirimleri */
                            if($ayar['smtp_durum'] == '1' ) {
                                include 'includes/post/mailtemp/users/ticket_user_yanit_mail_temp.php';
                            }
                            /* E-Posta Bildirimleri SON */
                            /* SMS */
                            if($sms['durum'] == '1' ) {
                                if($sms['sms_ticket_site'] == '1') {
                                    include 'includes/post/smstemp/users/ticket_reply_sms.php';
                                    include 'includes/post/smstemp/sms_api.php';
                                }
                            }
                            /*  <========SON=========>>> SMS SON */
                            $_SESSION['destek_alert'] = 'success';
                            header('Location:'.$ayar['site_url'].'hesabim/destek-detay/'.$destekno.'/');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    $_SESSION['destek_alert'] = 'empty';
                    header('Location:'.$ayar['site_url'].'hesabim/destek-detay/'.$destekno.'/');
                }
            }else{
                header('Location:'.$ayar['site_url'].'404');
            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        $_SESSION['demo_alert'] = 'demo';
        header('Location:'.$ayar['site_url'].'hesabim/destek-detay/'.$destekno.'/');
    }
} else {
    header('Location:'.$ayar['site_url'].'404');
}
?>