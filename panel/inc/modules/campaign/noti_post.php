<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' ||  $_GET['status'] == 'edit' || $_GET['status'] == 'settings' || $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete') {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            $timestamp = date('Y-m-d G:i:s');

            /* Set */
            if($_GET['status'] == 'settings'  ) {
                if ($_POST && isset($_POST['update'])) {
                    $guncelle = $db->prepare("UPDATE bildirimler_ayar  SET
                           durum=:durum, 
                           tur=:tur,
                           meta_desc=:meta_desc,
                           tags=:tags,
                           font_select=:font_select,
                           detay_bg=:detay_bg
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                       'durum' => $_POST['durum'],
                        'tur' => $_POST['tur'],
                        'meta_desc' => $_POST['meta_desc'],
                        'tags' => $_POST['tags'],
                        'font_select' => $_POST['font_select'],
                        'detay_bg' => colorFormat($_POST['detay_bg'])
                    ));
                    if($sonuc){

                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                    }else{
                    echo 'Veritabanı Hatası';
                    }

                }else{
                    $_SESSION['main_alert'] = 'zorunlu';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                }
            }
            /*  <========SON=========>>> Set SON */

            /*  Add */
            if($_GET['status'] == 'add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['baslik'] && $_POST['icerik'] )  {


                        if($_POST['tur'] == '2' ) {
                         if($_POST['user_sec'] <='0' || $_POST['user_sec']==null  ) {
                             $_SESSION['main_alert'] = 'zorunlu';
                             header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                             exit();
                         }
                        }

                        $rand= rand(0,(int) 99999999);

                                 $kaydet = $db->prepare("INSERT INTO bildirimler SET
                                    bildirim_id=:bildirim_id,
                                    tarih=:tarih,
                                    durum=:durum,
                                    dil=:dil,
                                    ikon=:ikon,
                                    tur=:tur,
                                    uye_id=:uye_id,
                                     baslik=:baslik,   
                                     icerik=:icerik
                                            ");
                                 $sonuc = $kaydet->execute(array(
                                     'bildirim_id' => $rand,
                                     'tarih' => $timestamp,
                                     'durum' => $_POST['durum'],
                                     'dil' => $_SESSION['dil'],
                                     'ikon' => $_POST['ikon'],
                                     'tur' => $_POST['tur'],
                                     'uye_id' => $_POST['user_sec'],
                                     'baslik' => $_POST['baslik'],
                                     'icerik' => $_POST['icerik']
                                 ));
                                 if($sonuc){
                                     $_SESSION['main_alert'] = 'success';
                                     header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                                 }else{
                                     echo 'Veritabanı Hatası';
                                 }


                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  Edit */
            if($_GET['status'] == 'edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if($_POST['baslik'] && $_POST['icerik'] && $_POST['noti_id']) {
                    $guncelle = $db->prepare("UPDATE bildirimler SET
                                    durum=:durum,
                                    ikon=:ikon,
                                     baslik=:baslik,   
                                     icerik=:icerik   
                     WHERE id={$_POST['noti_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $_POST['durum'],
                        'ikon' => $_POST['ikon'],
                        'baslik' => $_POST['baslik'],
                        'icerik' => $_POST['icerik']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /*  delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from bildirimler where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from bildirimler WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */

            /* Multi Delete */
            if($_GET['status'] == 'multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from bildirimler where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from bildirimler WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=notifications');
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