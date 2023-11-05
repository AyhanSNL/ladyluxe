<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'submenu_add' ||  $_GET['status'] == 'submenu_multidelete' || $_GET['status'] == 'submenu_delete' || $_GET['status'] == 'submenu_edit' || $_GET['status'] == 'update' || $_GET['status'] == 'delete' ||  $_GET['status'] == 'theme_settings' ) {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            if($_GET['status'] == 'theme_settings'  ) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_footer_settings');
                $_SESSION['collepse_status'] = 'genelAcc';
            }

            /* Submenu Insert */
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

                    $kaydet = $db->prepare("INSERT INTO footer_link SET
                                    baslik=:baslik,
                                    ust_id=:ust_id,
                                    ikon=:ikon,
                                    dil=:dil,
                                    durum=:durum,
                                    yeni_sekme=:yeni_sekme,
                                    sira=:sira,
                                    url_tur=:url_tur,
                                    url_adres=:url_adres            
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'ust_id' => $_POST['parent_id'],
                        'ikon' => $_POST['ikon'],
                        'dil' => $_SESSION['dil'],
                        'durum' => $_POST['durum'],
                        'yeni_sekme' => $_POST['yeni_sekme'],
                        'sira' => $_POST['sira'],
                        'url_tur' => $url_tur,
                        'url_adres' => $url
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=footer_sub_links&parent='.$_POST['parent_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Submenu Insert SON */

            /*  Submenu Update */
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

                    $guncelle = $db->prepare("UPDATE footer_link SET
                                         baslik=:baslik,
                                    ikon=:ikon,
                                    durum=:durum,
                                    yeni_sekme=:yeni_sekme,
                                    sira=:sira,
                                    url_tur=:url_tur,
                                    url_adres=:url_adres    
                     WHERE id={$_POST['link_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'ikon' => $_POST['ikon'],
                        'durum' => $_POST['durum'],
                        'yeni_sekme' => $_POST['yeni_sekme'],
                        'sira' => $_POST['sira'],
                        'url_tur' => $url_tur,
                        'url_adres' => $url
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=footer_sub_links&parent='.$_POST['parent_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Submenu Update SON */

            /*  Insert */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    $kaydet = $db->prepare("INSERT INTO footer_link SET
                                    baslik=:baslik,
                                    ikon=:ikon,
                                    dil=:dil,
                                    durum=:durum,
                                    ust_id=:ust_id,
                                    sira=:sira
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'ikon' => $_POST['ikon'],
                        'dil' => $_SESSION['dil'],
                        'durum' => $_POST['durum'],
                        'ust_id' => '0',
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=footer_links');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Insert SON */

            /*  Update */
            if($_GET['status'] == 'update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE footer_link SET
                               baslik=:baslik,
                                    ikon=:ikon,
                                    durum=:durum,
                                    sira=:sira 
                     WHERE id={$_POST['link_no']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'ikon' => $_POST['ikon'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=footer_links');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Update SON */

            /* Delete */
            if($_GET['status'] == 'delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {

                    $silmeislem = $db->prepare("DELETE from footer_link WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                       'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {

                        $sorguSub1 = $db->prepare("select * from footer_link where ust_id=:ust_id ");
                        $sorguSub1->execute(array(
                            'ust_id' => $_GET['no'],
                        ));
                       if($sorguSub1->rowCount()>'0'  ) {
                           $silmeislem = $db->prepare("DELETE from footer_link WHERE ust_id=:ust_id");
                           $silmeislem->execute(array(
                               'ust_id' => $_GET['no']
                           ));
                       }



                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=footer_links');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Delete SON */



            /* Submenu Delete */
            if($_GET['status'] == 'submenu_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {

                    $silmeislem = $db->prepare("DELETE from footer_link WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=footer_sub_links&parent='.$_GET['parent'].'');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Submenu Delete SON */

            /* Submenu Multi Delete */
            if($_GET['status'] == 'submenu_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from footer_link where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from footer_link WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=footer_sub_links&parent='.$_GET['parent'].'');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=footer_sub_links&parent='.$_GET['parent'].'');
                }
            }
            /*  <========SON=========>>> Submenu Multi Delete SON */

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