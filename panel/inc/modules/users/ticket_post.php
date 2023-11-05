<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'msg_edit' || $_GET['status'] == 'msg_add' || $_GET['status'] == 'delete' ) {

            $timestamp = date('Y-m-d G:i:s');

            /* MSG Edit */
            if($_GET['status'] == 'msg_edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_POST['msg_id'] && $_POST['destek_no']) {
                        $guncelle = $db->prepare("UPDATE destek_talep_mesaj SET
                                 mesaj=:mesaj,
                                 admin_isim=:admin_isim
                         WHERE id={$_POST['msg_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'mesaj' => $_POST['mesaj'],
                            'admin_isim' => $adminRow['isim'].' '.$adminRow['soyisim']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=ticket_detail&ticketID='.$_POST['destek_no'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=ticket_detail&ticketID='.$_POST['destek_no'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> MSG Edit SON
            
            /* MSG Add */
            if($_GET['status'] == 'msg_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['mesaj'] && $_POST['destek_no']) {
                       
                        $kaydet = $db->prepare("INSERT INTO destek_talep_mesaj SET
                           tarih=:tarih,     
                           gonderen=:gonderen,
                           mesaj=:mesaj,
                           admin_isim=:admin_isim,
                           destek_no=:destek_no
                        ");
                        $sonuc = $kaydet->execute(array(
                            'tarih' => $timestamp,
                            'gonderen' => '0',
                            'mesaj' => $_POST['mesaj'],
                            'admin_isim' => $adminRow['isim'].' '.$adminRow['soyisim'],
                            'destek_no' => $_POST['destek_no']
                        ));
                        if($sonuc){
                            /* Destek Talebi Güncellemesi */
                            $guncelle = $db->prepare("UPDATE destek_talebi SET
                                    son_islem=:son_islem,
                                    yeni=:yeni,
                                    durum=:durum
                             WHERE destek_no={$_POST['destek_no']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'son_islem' => $timestamp,
                                'yeni' => '0',
                                'durum' => '1'
                            ));
                            /*  <========SON=========>>> Destek Talebi Güncellemesi SON */



                            /* bildirim Merkezi */
                            if($_POST['sms_go'] == '1' || $_POST['email_go'] == '1' || $_POST['noti_go'] == '1'  ) {

                                if($_POST['email_go'] == '1'  ) {
                                    if($ayar['smtp_durum'] == '1' ) {
                                        $ticket = $db->prepare("select * from destek_talebi where destek_no=:destek_no ");
                                        $ticket->execute(array(
                                            'destek_no' => $_POST['destek_no'],
                                        ));
                                        if($ticket->rowCount()>'0'  ) {
                                            $destekRow = $ticket->fetch(PDO::FETCH_ASSOC);
                                            $user = $destekRow['uye_id'];
                                            $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                            $kullaniciCek->execute(array(
                                                'id' => $user
                                            ));
                                            if($kullaniciCek->rowCount()>'0'  ) {
                                                $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                                $eposta = $userRow['eposta'];
                                                $isim = $userRow['isim'];
                                                $soyisim = $userRow['soyisim'];
                                                include 'inc/modules/users/ticket_email_post.php';
                                            }
                                        }
                                    }
                                }

                                if($_POST['sms_go'] == '1'  ) {
                                    if($sms['durum'] == '1' ) {
                                        $ticket = $db->prepare("select * from destek_talebi where destek_no=:destek_no ");
                                        $ticket->execute(array(
                                            'destek_no' => $_POST['destek_no'],
                                        ));
                                        if($ticket->rowCount()>'0'  ) {
                                            $destekRow = $ticket->fetch(PDO::FETCH_ASSOC);
                                            $user = $destekRow['uye_id'];
                                            $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                            $kullaniciCek->execute(array(
                                                'id' => $user
                                            ));
                                            if($kullaniciCek->rowCount()>'0'  ) {
                                                $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                                $numara = $userRow['telefon'];
                                                $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', #'.$_POST['destek_no'].' '.$diller['adminpanel-bildirim-text-10'].''.$diller['adminpanel-bildirim-text-11'].'';
                                                include 'inc/modules/users/ticket_sms_post.php';
                                            }
                                        }
                                    }
                                }

                                if($_POST['noti_go'] == '1'  ) {
                                    if($notiSet['durum'] == '1' ) {
                                        $ticket = $db->prepare("select * from destek_talebi where destek_no=:destek_no ");
                                        $ticket->execute(array(
                                            'destek_no' => $_POST['destek_no'],
                                        ));
                                        if($ticket->rowCount()>'0'  ) {
                                            $destekRow = $ticket->fetch(PDO::FETCH_ASSOC);
                                            $user = $destekRow['uye_id'];
                                            $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                                            $kullaniciCek->execute(array(
                                                'id' => $user
                                            ));
                                            if($kullaniciCek->rowCount()>'0'  ) {
                                                $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                                                $rand = rand(0,(int) 9999999999);
                                                $baslik = $diller['adminpanel-bildirim-text-9'];
                                                $icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', <br><br> #'.$_POST['destek_no'].' '.$diller['adminpanel-bildirim-text-10'].'';
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
                                                    'ikon' => '&#128172;',
                                                    'uye_id' => $user,
                                                    'durum' => '1',
                                                    'dil' => $_SESSION['dil']
                                                ));
                                                /*  <========SON=========>>> Site içi bildirim gönder SON */

                                            }
                                        }
                                    }
                                }
                            }
                            /*  <========SON=========>>> bildirim Merkezi SON */

                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=ticket_detail&ticketID='.$_POST['destek_no'].'');
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                      
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=ticket_detail&ticketID='.$_POST['destek_no'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=ticket_detail&ticketID='.$_POST['destek_no'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }            
            /*  <========SON=========>>> MSG Add SON */

            /*  delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from 	destek_talebi where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from 	destek_talebi WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {

                            $silmeislem = $db->prepare("DELETE from destek_talep_mesaj WHERE destek_no=:destek_no");
                            $silmeislem->execute(array(
                               'destek_no' => $resim['destek_no']
                            ));

                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=tickets');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=tickets');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */


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