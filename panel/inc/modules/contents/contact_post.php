<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'workhour_edit' || $_GET['status'] == 'workhour_add' || $_GET['status'] == 'edit' ||  $_GET['status'] == 'delete'  ) {

            /* Work Edit */
            if($_GET['status'] == 'workhour_edit') {
                if ($_POST && isset($_POST['update'])) {
                    if ($_POST['work_id']) {
                        $guncelle = $db->prepare("UPDATE calisma_saatleri SET
                            icerik=:icerik
                         WHERE id={$_POST['work_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'icerik' => $_POST['icerik']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            $_SESSION['collepse_status'] = 'timeAcc';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Work Edit SON */

            /* Work Add */
            if($_GET['status'] == 'workhour_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                        $kaydet = $db->prepare("INSERT INTO calisma_saatleri SET
                             icerik=:icerik,
                             dil=:dil   
                        ");
                        $sonuc = $kaydet->execute(array(
                            'icerik' => $_POST['icerik'],
                            'dil' => $_SESSION['dil']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            $_SESSION['collepse_status'] = 'timeAcc';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Work Add SON */


            /*  Add */
            if($_GET['status'] == 'add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['baslik'] && $_POST['sira'] && $_POST['icerik']) {
                        $kaydet = $db->prepare("INSERT INTO iletisim_bilgileri SET
                               baslik=:baslik,    
                               dil=:dil,
                            ikon=:ikon,
                            durum=:durum,   
                            icerik=:icerik,
                            adres_url=:adres_url,
                            sira=:sira,
                            col_md=:col_md
                        ");
                        $sonuc = $kaydet->execute(array(
                            'baslik' => $_POST['baslik'],
                            'dil' => $_SESSION['dil'],
                            'ikon' => $_POST['ikon'],
                            'durum' => $_POST['durum'],
                            'icerik' => $_POST['icerik'],
                            'adres_url' => $_POST['adres_url'],
                            'sira' => $_POST['sira'],
                            'col_md' => $_POST['col_md']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Intro Add SON */

            /*  Edit */
            if($_GET['status'] == 'edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_POST['baslik'] && $_POST['sira'] && $_POST['contact_id'] && $_POST['icerik']) {
                        $guncelle = $db->prepare("UPDATE iletisim_bilgileri SET
                            baslik=:baslik,    
                            ikon=:ikon,
                            durum=:durum,   
                            icerik=:icerik,
                            adres_url=:adres_url,
                            sira=:sira,
                            col_md=:col_md
                         WHERE id={$_POST['contact_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'ikon' => $_POST['ikon'],
                            'durum' => $_POST['durum'],
                            'icerik' => $_POST['icerik'],
                            'adres_url' => $_POST['adres_url'],
                            'sira' => $_POST['sira'],
                            'col_md' => $_POST['col_md']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Intro Edit SON */


            /*  delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from iletisim_bilgileri where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from iletisim_bilgileri WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=contact_page');
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