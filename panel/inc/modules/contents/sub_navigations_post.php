<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'font_settings' || $_GET['status'] == 'submenu_multidelete'  ||  $_GET['status'] == 'add' ||  $_GET['status'] == 'edit' ||  $_GET['status'] == 'submenu_add' ||  $_GET['status'] == 'delete' ||  $_GET['status'] == 'submenu_edit' ||  $_GET['status'] == 'submenu_delete') {


            /* Font Update */
            if($_GET['status'] == 'font_settings'  ) {
                if($_POST && isset($_POST['update'])  && $_POST['nav_font'] ) {
                    $guncelle = $db->prepare("UPDATE ayarlar SET
                           nav_font=:nav_font
                    WHERE id='1'      
                   ");
                    $sonuc = $guncelle->execute(array(
                        'nav_font' => $_POST['nav_font']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['collepse_status'] = 'fontAcc';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Font Update SON */

            /* cat Add */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                   if($_POST['baslik'] && $_POST['sira']  ) {
                        $kaydet = $db->prepare("INSERT INTO navigasyon SET
                                baslik=:baslik,
                                sira=:sira,
                                durum=:durum,
                                dil=:dil,
                                ikon=:ikon,
                                ust_id=:ust_id
                        ");
                        $sonuc = $kaydet->execute(array(
                            'baslik' => $_POST['baslik'],
                            'sira' => $_POST['sira'],
                            'durum' => $_POST['durum'],
                            'dil' => $_SESSION['dil'],
                            'ikon' => $_POST['ikon'],
                            'ust_id' => '0'
                        ));
                       if($sonuc){
                           $_SESSION['main_alert'] = 'success';
                           header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations');
                       }else{
                           echo 'Veritabanı Hatası';
                       }
                   }else{
                       $_SESSION['main_alert'] = 'zorunlu';
                       header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations');  
                   }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> cat Add SON */

            /* cat Edit */
            if($_GET['status'] == 'edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['sira']  ) {
                        $guncelle = $db->prepare("UPDATE navigasyon SET
                                baslik=:baslik,
                                sira=:sira,
                                durum=:durum,
                                ikon=:ikon
                         WHERE id={$_POST['nav_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'sira' => $_POST['sira'],
                            'durum' => $_POST['durum'],
                            'ikon' => $_POST['ikon']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> cat Edit SON */

            /* cat Delete */
            if($_GET['status'] == 'delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {

                    $silmeislem = $db->prepare("DELETE from navigasyon WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {

                        $sorguSub1 = $db->prepare("select * from navigasyon where ust_id=:ust_id ");
                        $sorguSub1->execute(array(
                            'ust_id' => $_GET['no'],
                        ));
                        if($sorguSub1->rowCount()>'0'  ) {
                            $silmeislem = $db->prepare("DELETE from navigasyon WHERE ust_id=:ust_id");
                            $silmeislem->execute(array(
                                'ust_id' => $_GET['no']
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> cat Delete SON */

            /* SubLinks Add */
            if($_GET['status'] == 'submenu_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    /* Link Türleri */
                    if($_POST['url_tur']==!null  ) {
                        /* url olmasın */
                        if($_POST['url_tur']=='0'  ) {
                            $url = null;
                            $url_tur = '0';
                        }
                        /*  <========SON=========>>> url olmasın SON */

                        /* Modül Linki Seçili */
                        if($_POST['url_tur']=='1'  ) {
                            $url = $_POST['modul_url'];
                            $url_tur = '1';
                        }
                        /*  <========SON=========>>> Modül Linki Seçili SON */

                        /* Manuel URL */
                        if($_POST['url_tur']=='2'  ) {
                            $url = $_POST['manuel_url'];
                            $url_tur = '2';
                        }
                        /*  <========SON=========>>> Manuel URL SON */

                    }else{
                        $url = null;
                        $url_tur = '0';
                    }
                    /*  <========SON=========>>> Link Türleri SON */

                    $kaydet = $db->prepare("INSERT INTO navigasyon SET
                                    baslik=:baslik,
                                    ust_id=:ust_id,
                                    dil=:dil,
                                    durum=:durum,
                                    sira=:sira,
                                    url_tur=:url_tur,
                                    url_adres=:url_adres            
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'ust_id' => $_POST['parent_id'],
                        'dil' => $_SESSION['dil'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira'],
                        'url_tur' => $url_tur,
                        'url_adres' => $url
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations_links&parent='.$_POST['parent_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> cat Add SON */

            /*  SubLinks Update */
            if($_GET['status'] == 'submenu_edit'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    /* Link Türleri */
                    if($_POST['url_tur_edit']==!null  ) {
                        /* url olmasın */
                        if($_POST['url_tur_edit']=='0'  ) {
                            $url = null;
                            $url_tur = '0';
                        }
                        /*  <========SON=========>>> url olmasın SON */
                        /* Modül Linki Seçili */
                        if($_POST['url_tur_edit']=='1'  ) {
                            $url = $_POST['modul_url'];
                            $url_tur = '1';
                        }
                        /*  <========SON=========>>> Modül Linki Seçili SON */
                        /* Manuel URL */
                        if($_POST['url_tur_edit']=='2'  ) {
                            $url = $_POST['manuel_url'];
                            $url_tur = '2';
                        }
                        /*  <========SON=========>>> Manuel URL SON */
                    }else{
                        $url = null;
                        $url_tur = '0';
                    }
                    /*  <========SON=========>>> Link Türleri SON */

                    $guncelle = $db->prepare("UPDATE navigasyon SET
                                    baslik=:baslik,
                                    durum=:durum,
                                    sira=:sira,
                                    url_tur=:url_tur,
                                    url_adres=:url_adres    
                     WHERE id={$_POST['link_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira'],
                        'url_tur' => $url_tur,
                        'url_adres' => $url
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations_links&parent='.$_POST['parent_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  SubLinks Update SON */

            /* SubLinks Delete */
            if($_GET['status'] == 'submenu_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {

                    $silmeislem = $db->prepare("DELETE from navigasyon WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations_links&parent='.$_GET['parent'].'');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> SubLinks Delete SON */

            /* SubLinks Multi Delete */
            if($_GET['status'] == 'submenu_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from navigasyon where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from navigasyon WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations_links&parent='.$_GET['parent'].'');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=sub_navigations_links&parent='.$_GET['parent'].'');
                }
            }
            /*  <========SON=========>>> SubLinks Multi Delete SON */

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