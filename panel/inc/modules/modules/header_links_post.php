<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'submenu_add' ||  $_GET['status'] == 'submenu_multidelete' || $_GET['status'] == 'submenu_delete' || $_GET['status'] == 'submenu_edit' || $_GET['status'] == 'product_remove' || $_GET['status'] == 'update' || $_GET['status'] == 'delete' || $_GET['status'] == 'fixed_button_update' || $_GET['status'] == 'fixed_button_add' || $_GET['status'] == 'theme_settings' ) {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            if($_GET['status'] == 'theme_settings'  ) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                $_SESSION['collepse_status'] = 'menuAcc';
            }


            /*  SubMenu Add */
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



                    $kaydet = $db->prepare("INSERT INTO header_menu SET
                                    ust_id=:ust_id,
                                    url_tur=:url_tur,
                                    url=:url,
                                    baslik=:baslik,
                                    dil=:dil,
                                    durum=:durum,
                                    sira=:sira,
                                    yeni_sekme=:yeni_sekme
                    ");
                    $sonuc = $kaydet->execute(array(
                        'ust_id' => $_POST['parent_id'],
                        'url_tur' => $url_tur,
                        'url' => $url,
                        'baslik' => $_POST['baslik'],
                        'dil' => $_SESSION['dil'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira'],
                        'yeni_sekme' => $_POST['yeni_sekme']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_sub_links&parent='.$_POST['parent_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  SubMenu Add SON */
            /*  Update */
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
                    $guncelle = $db->prepare("UPDATE header_menu SET
                                    url_tur=:url_tur,
                                    url=:url,
                                    baslik=:baslik,
                                    durum=:durum,
                                    sira=:sira,
                                    yeni_sekme=:yeni_sekme 
                     WHERE id={$_POST['menu_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'url_tur' => $url_tur,
                        'url' => $url,
                        'baslik' => $_POST['baslik'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira'],
                        'yeni_sekme' => $_POST['yeni_sekme']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_sub_links&parent='.$_POST['parent_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Update SON */
            /* Submenu Delete */
            if($_GET['status'] == 'submenu_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {
                    $silmeislem = $db->prepare("DELETE from header_menu WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {
                        /* Bu id ye ait alt menuler varmı? */
                        $kontrolSql = $db->prepare("select * from header_menu where ust_id=:ust_id ");
                        $kontrolSql->execute(array(
                            'ust_id' => $_GET['no']
                        ));
                        if($kontrolSql->rowCount()>'0'  ) {
                            $silmeislem = $db->prepare("DELETE from header_menu WHERE ust_id=:ust_id");
                            $silmeislem->execute(array(
                                'ust_id' => $_GET['no']
                            ));
                        }
                        /*  <========SON=========>>> Bu id ye ait alt menuler varmı? SON */
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_sub_links&parent='.$_GET['parent'].'');
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
                        $sorgu = $db->prepare("select * from header_menu where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);

                            $silmeislem = $db->prepare("DELETE from header_menu WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));

                            /* Bu id ye ait alt menuler varmı? */
                            $kontrolSql = $db->prepare("select * from header_menu where ust_id=:ust_id ");
                            $kontrolSql->execute(array(
                                'ust_id' => $idler
                            ));
                            if($kontrolSql->rowCount()>'0'  ) {
                                $silmeislem = $db->prepare("DELETE from header_menu WHERE ust_id=:ust_id");
                                $silmeislem->execute(array(
                                    'ust_id' => $idler
                                ));
                            }
                            /*  <========SON=========>>> Bu id ye ait alt menuler varmı? SON */

                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=header_sub_links&parent='.$_GET['parent'].'');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=header_sub_links&parent='.$_GET['parent'].'');
                }
            }
            /*  <========SON=========>>> Submenu Multi Delete SON */


            if($_GET['status'] == 'product_remove'  ) {
                if(isset($_GET['no']) && isset($_GET['pid']) && $_GET['no'] == !null && $_GET['pid']== !null  ) {

                    $eskiSql = $db->prepare("select * from header_menu where id='$_GET[no]' ");
                    $eskiSql->execute();
                    $eskiRow = $eskiSql->fetch(PDO::FETCH_ASSOC);

                    $eskiurunler = $eskiRow['sablon2_urunler'];

                    $yeniurunler  = $eskiurunler;
                    $eski   = $_GET['pid'].',';
                    $yeni   = '';
                    $yeniurunler = str_replace($eski, $yeni, $yeniurunler);


                    $guncelle = $db->prepare("UPDATE header_menu SET
                            sablon2_urunler=:sablon2_urunler
                     WHERE id={$_GET['no']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'sablon2_urunler' => $yeniurunler
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_links_edit&link_id='.$_GET['no'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }



                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            /* Sabit Buton */
            if($_GET['status'] == 'fixed_button_add'  ) {
                if ($_POST && isset($_POST['insert'])) {

                    /* Link Türleri */
                    if($_POST['url_tur_sabit']==!null  ) {


                        /* url olmasın */
                        if($_POST['url_tur_sabit']=='0'  ) {
                            $url = null;
                            $url_tur = '0';
                        }
                        /*  <========SON=========>>> url olmasın SON */

                        /* Modül Linki Seçili */
                        if($_POST['url_tur_sabit']=='1'  ) {
                            $url = $_POST['modul_url'];
                            $url_tur = '1';
                        }
                        /*  <========SON=========>>> Modül Linki Seçili SON */

                        /* Manuel URL */
                        if($_POST['url_tur_sabit']=='2'  ) {
                            $url = $_POST['manuel_url'];
                            $url_tur = '2';
                        }
                        /*  <========SON=========>>> Manuel URL SON */

                    }else{
                        $url = null;
                        $url_tur = '0';
                    }
                    /*  <========SON=========>>> Link Türleri SON */

                    $kaydet = $db->prepare("INSERT INTO header_sabit_buton SET
                        durum=:durum,
                            baslik=:baslik,
                            renk=:renk,
                            url_tur=:url_tur,   
                            dil=:dil, 
                            url=:url,
                            yeni_sekme=:yeni_sekme     
              ");
                    $sonuc = $kaydet->execute(array(
                        'durum' => $_POST['durum'],
                        'baslik' => $_POST['baslik'],
                        'renk' => $_POST['renk'],
                        'url_tur' => $url_tur,
                        'dil' => $_SESSION['dil'],
                        'url' => $url,
                        'yeni_sekme' => $_POST['yeni_sekme_2']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_links');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'fixed_button_update'  ) {
                if ($_POST && isset($_POST['update'])) {

                    /* Link Türleri */
                    if($_POST['url_tur_sabit']==!null  ) {


                        /* url olmasın */
                        if($_POST['url_tur_sabit']=='0'  ) {
                            $url = null;
                            $url_tur = '0';
                        }
                        /*  <========SON=========>>> url olmasın SON */

                        /* Modül Linki Seçili */
                        if($_POST['url_tur_sabit']=='1'  ) {
                            $url = $_POST['modul_url'];
                            $url_tur = '1';
                        }
                        /*  <========SON=========>>> Modül Linki Seçili SON */

                        /* Manuel URL */
                        if($_POST['url_tur_sabit']=='2'  ) {
                            $url = $_POST['manuel_url'];
                            $url_tur = '2';
                        }
                        /*  <========SON=========>>> Manuel URL SON */

                    }else{
                        $url = null;
                        $url_tur = '0';
                    }
                    /*  <========SON=========>>> Link Türleri SON */

                    $guncelle = $db->prepare("UPDATE header_sabit_buton SET
                            durum=:durum,
                            baslik=:baslik,
                            renk=:renk,
                            url_tur=:url_tur,    
                            url=:url,
                            yeni_sekme=:yeni_sekme
                         WHERE id={$_POST['button_id_number']}      
                        ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $_POST['durum'],
                        'baslik' => $_POST['baslik'],
                        'renk' => $_POST['renk'],
                        'url_tur' => $url_tur,
                        'url' => $url,
                        'yeni_sekme' => $_POST['yeni_sekme_2']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_links');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Sabit Buton SON */

            /*  Insert */
            if($_GET['status'] == 'add'  ) {
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


                    /* Ürün Seçilmişse */
                    if($_POST['sablon2_urunler'] == !null  ) {
                        $urunlist = $_POST['sablon2_urunler'];

                        foreach ($urunlist as $urun){
                            $urunler.= $urun.",";
                        }


                    }else{
                        $urunler = null;
                    }
                    /*  <========SON=========>>> Ürün Seçilmişse SON */

                    $kaydet = $db->prepare("INSERT INTO header_menu SET
                                    url_tur=:url_tur,
                                    url=:url,
                                    baslik=:baslik,
                                    dil=:dil,
                                    durum=:durum,
                                    ust_id=:ust_id,
                                    sira=:sira,
                                    yeni_sekme=:yeni_sekme,
                                    menu_sablon=:menu_sablon,
                                    sablon_content_bg=:sablon_content_bg,
                                    sablon_content_text_color=:sablon_content_text_color,
                                    sablon_content_border=:sablon_content_border,
                                    sablon2_content_tip=:sablon2_content_tip,
                                    sablon_2_icerik=:sablon_2_icerik,
                                    sablon2_urunler=:sablon2_urunler
                    ");
                    $sonuc = $kaydet->execute(array(
                        'url_tur' => $url_tur,
                        'url' => $url,
                        'baslik' => $_POST['baslik'],
                        'dil' => $_SESSION['dil'],
                        'durum' => $_POST['durum'],
                        'ust_id' => '0',
                        'sira' => $_POST['sira'],
                        'yeni_sekme' => $_POST['yeni_sekme'],
                        'menu_sablon' => $_POST['menu_sablon'],
                        'sablon_content_bg' => colorFormat($_POST['sablon_content_bg']),
                        'sablon_content_text_color' => colorFormat($_POST['sablon_content_text_color']),
                        'sablon_content_border' => colorFormat($_POST['sablon_content_border']),
                        'sablon2_content_tip' => $_POST['sablon2_content_tip'],
                        'sablon_2_icerik' => $_POST['sablon_2_icerik'],
                        'sablon2_urunler' => $urunler
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_links');
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

                    /* Ürün Seçilmişse */
                    $oncekiUrunlerSql = $db->prepare("select * from header_menu where id='$_POST[link_no]' ");
                    $oncekiUrunlerSql->execute();
                    $onceki = $oncekiUrunlerSql->fetch(PDO::FETCH_ASSOC);

                    if($_POST['sablon2_urunler'] >0 ) {
                        if($onceki['sablon2_urunler'] >0 ) {
                            $urunlist = $_POST['sablon2_urunler'];
                            foreach ($urunlist as $urun){
                                $yeniurunler.= $urun.",";
                            }
                            $urunler = ''.$onceki['sablon2_urunler'].','.$yeniurunler.'';
                        }else{
                            $urunlist = $_POST['sablon2_urunler'];
                            foreach ($urunlist as $urun){
                                $yeniurunler.= $urun.",";
                            }
                            $urunler = $yeniurunler;
                        }
                    }else{
                        $urunler = $onceki['sablon2_urunler'];
                    }
                    /*  <========SON=========>>> Ürün Seçilmişse SON */

                    $guncelle = $db->prepare("UPDATE header_menu SET
                                    url_tur=:url_tur,
                                    url=:url,
                                    baslik=:baslik,
                                    durum=:durum,
                                    sira=:sira,
                                    yeni_sekme=:yeni_sekme,
                                    menu_sablon=:menu_sablon,
                                    sablon_content_bg=:sablon_content_bg,
                                    sablon_content_text_color=:sablon_content_text_color,
                                    sablon_content_border=:sablon_content_border,
                                    sablon2_content_tip=:sablon2_content_tip,
                                    sablon_2_icerik=:sablon_2_icerik,
                                    sablon2_urunler=:sablon2_urunler   
                     WHERE id={$_POST['link_no']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'url_tur' => $url_tur,
                        'url' => $url,
                        'baslik' => $_POST['baslik'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira'],
                        'yeni_sekme' => $_POST['yeni_sekme'],
                        'menu_sablon' => $_POST['menu_sablon'],
                        'sablon_content_bg' => colorFormat($_POST['sablon_content_bg']),
                        'sablon_content_text_color' => colorFormat($_POST['sablon_content_text_color']),
                        'sablon_content_border' => colorFormat($_POST['sablon_content_border']),
                        'sablon2_content_tip' => $_POST['sablon2_content_tip'],
                        'sablon_2_icerik' => $_POST['sablon_2_icerik'],
                        'sablon2_urunler' => $urunler
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_links_edit&link_id='.$_POST['link_no'].'');
                    }else{
                        echo 'Veritabanı Hatasısss';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Update SON */

            /* Delete */
            if($_GET['status'] == 'delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {

                    $silmeislem = $db->prepare("DELETE from header_menu WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {

                        $sorguSub1 = $db->prepare("select * from header_menu where ust_id=:ust_id ");
                        $sorguSub1->execute(array(
                            'ust_id' => $_GET['no'],
                        ));
                        foreach ($sorguSub1 as $sub1Row){

                            $sorguSub2 = $db->prepare("select * from header_menu where ust_id=:ust_id ");
                            $sorguSub2->execute(array(
                                'ust_id' => $sub1Row['id'],
                            ));
                            if($sorguSub2->rowCount()>'0'  ) {
                                foreach ($sorguSub2 as $sub2Row){
                                    $silmeislem = $db->prepare("DELETE from header_menu WHERE id=:id");
                                    $silmeislem->execute(array(
                                        'id' => $sub2Row['id']
                                    ));
                                }
                                $silmeislem2 = $db->prepare("DELETE from header_menu WHERE id=:id");
                                $silmeislem2->execute(array(
                                    'id' => $sub1Row['id']
                                ));
                            }else{
                                $silmeislem = $db->prepare("DELETE from header_menu WHERE id=:id");
                                $silmeislem->execute(array(
                                    'id' => $sub1Row['id']
                                ));
                            }

                        }


                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=header_links');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Delete SON */


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