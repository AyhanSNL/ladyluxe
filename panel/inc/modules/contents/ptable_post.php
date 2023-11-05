<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'catadd' || $_GET['status'] == 'cat_multidelete' || $_GET['status'] == 'cat_delete' || $_GET['status'] == 'features_delete' || $_GET['status'] == 'list_multidelete'  || $_GET['status'] == 'list_delete' || $_GET['status'] == 'features_multidelete' || $_GET['status'] == 'features_edit' || $_GET['status'] == 'features_add' || $_GET['status'] == 'catedit' || $_GET['status'] == 'table_edit' || $_GET['status'] == 'cat_multidelete' || $_GET['status'] == 'table_add' ) {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            /* Cat Delete */
            if($_GET['status'] == 'cat_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {

                    $silmeislem = $db->prepare("DELETE from pricing_kat WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {

                        $sorguSub1 = $db->prepare("select * from pricing where kat_id=:kat_id ");
                        $sorguSub1->execute(array(
                            'kat_id' => $_GET['no'],
                        ));
                        foreach ($sorguSub1 as $sub1Row){

                            $sorguSub2 = $db->prepare("select * from pricing_ozellik where pr_id=:pr_id ");
                            $sorguSub2->execute(array(
                                'pr_id' => $sub1Row['id'],
                            ));
                            if($sorguSub2->rowCount()>'0'  ) {
                                foreach ($sorguSub2 as $sub2Row){
                                    $silmeislem = $db->prepare("DELETE from pricing_ozellik WHERE id=:id");
                                    $silmeislem->execute(array(
                                        'id' => $sub2Row['id']
                                    ));
                                }
                                $silmeislem2 = $db->prepare("DELETE from pricing WHERE id=:id");
                                $silmeislem2->execute(array(
                                    'id' => $sub1Row['id']
                                ));
                            }else{
                                $silmeislem = $db->prepare("DELETE from pricing WHERE id=:id");
                                $silmeislem->execute(array(
                                    'id' => $sub1Row['id']
                                ));
                            }

                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                    }else {
                        echo 'veritabanı hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'cat_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){

                        /* Önce Tablolar */
                        $tablo = $db->prepare("select * from pricing where kat_id='$idler' ");
                        $tablo->execute();
                        if($tablo->rowCount()>'0'  ) {
                            foreach ($tablo as $tabloRow){
                                /* Özellik Kontrol */
                                    $tabloOzellik = $db->prepare("select * from pricing_ozellik where pr_id='$tabloRow[id]' ");
                                    $tabloOzellik->execute();
                                    if($tabloOzellik->rowCount()>'0'  ) {
                                    /* Özellik silindi */
                                        $silmeislem = $db->prepare("DELETE from pricing_ozellik WHERE pr_id=:pr_id");
                                        $silmeislem->execute(array(
                                            'pr_id' => $tabloRow['id']
                                        ));
                                    /*  <========SON=========>>> Özellik silindi SON */
                                        /* Tablo silindi */
                                        $silmeislem2 = $db->prepare("DELETE from pricing WHERE id=:id");
                                        $silmeislem2->execute(array(
                                            'id' => $tabloRow['id']
                                        ));
                                        /*  <========SON=========>>> Tablo silindi SON */
                                    }else{
                                        $silmeislem2 = $db->prepare("DELETE from pricing WHERE id=:id");
                                        $silmeislem2->execute(array(
                                            'id' => $tabloRow['id']
                                        ));
                                    }

                                /*  <========SON=========>>> Özellik Kontrol SON */
                            }
                        }
                        /*  <========SON=========>>> Önce Tablolar SON */
                        $deletes = $db->prepare("DELETE from pricing_kat WHERE id=:id");
                        $deletes->execute(array(
                            'id' => $idler
                        ));
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                }
            }
            /*  <========SON=========>>> Cat Delete SON */

            /*  table Delete */
            if($_GET['status'] == 'list_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null && $_GET['parent'] == !null ) {
                    $silmeislem = $db->prepare("DELETE from pricing WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {
                        $ozCek = $db->prepare("select * from pricing_ozellik where pr_id=:pr_id ");
                        $ozCek->execute(array(
                            'pr_id' => $_GET['no']
                        ));
                        if($ozCek->rowCount()>'0'  ) {
                         $dels = $db->prepare("DELETE from pricing_ozellik WHERE pr_id=:pr_id");
                         $dels->execute(array(
                            'pr_id' => $_GET['no']
                         ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_list&parent='.$_GET['parent'].'');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'list_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        /* Özellik sil */
                        $ozCek = $db->prepare("select * from pricing_ozellik where pr_id=:pr_id ");
                        $ozCek->execute(array(
                            'pr_id' => $idler
                        ));
                        if($ozCek->rowCount()>'0'  ) {
                            $dels = $db->prepare("DELETE from pricing_ozellik WHERE pr_id=:pr_id");
                            $dels->execute(array(
                                'pr_id' => $idler
                            ));
                        }
                        /*  <========SON=========>>> Özellik sil SON */
                        $sorgu = $db->prepare("select * from pricing where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                            $silmeislem = $db->prepare("DELETE from pricing WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_list&parent='.$_GET['parent'].'');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_list&parent='.$_GET['parent'].'');
                }
            }
            /*  <========SON=========>>>  table Delete SON */

            /*  feat Delete */
            if($_GET['status'] == 'features_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null && $_GET['parent_id'] == !null ) {
                    $silmeislem = $db->prepare("DELETE from pricing_ozellik WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_features&parent='.$_GET['parent_id'].'');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'features_multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from pricing_ozellik where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                            $silmeislem = $db->prepare("DELETE from pricing_ozellik WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_features&parent='.$_GET['parent'].'');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_features&parent='.$_GET['parent'].'');
                }
            }
            /*  <========SON=========>>>  feat Delete SON */

            if($_GET['status'] == 'features_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['baslik'] && $_POST['sira'] && $_POST['pr_id'] ) {
                        $kaydet = $db->prepare("INSERT INTO pricing_ozellik SET
                         dil=:dil,   
                         sira=:sira,
                         baslik=:baslik,
                         spot=:spot,
                         pr_id=:pr_id,
                        bg_renk=:bg_renk,
                        yazi_renk=:yazi_renk
                    ");
                        $sonuc = $kaydet->execute(array(
                            'dil' => $_SESSION['dil'],
                            'sira' => $_POST['sira'],
                            'baslik' => $_POST['baslik'],
                            'spot' => $_POST['spot'],
                            'pr_id' => $_POST['pr_id'],
                            'bg_renk' => colorFormat($_POST['bg_renk']),
                            'yazi_renk' => colorFormat($_POST['yazi_renk'])
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_features&parent='.$_POST['pr_id'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }

                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_features&parent='.$_POST['pr_id'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'features_edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['sira'] && $_POST['oz_id'] && $_POST['parent_id']  ) {
                        $guncelle = $db->prepare("UPDATE pricing_ozellik SET
                             sira=:sira,
                             baslik=:baslik,
                             spot=:spot,
                             bg_renk=:bg_renk,
                             yazi_renk=:yazi_renk
                             WHERE id={$_POST['oz_id']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'sira' => $_POST['sira'],
                            'baslik' => $_POST['baslik'],
                            'spot' => $_POST['spot'],
                            'bg_renk' => colorFormat($_POST['bg_renk']),
                            'yazi_renk' => colorFormat($_POST['yazi_renk'])
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_features&parent='.$_POST['parent_id'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_features&parent='.$_POST['parent_id'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'table_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['baslik'] && $_POST['sira'] && $_POST['parent_id'] ) {
                        if($_POST['fiyat'] == !null  ) {
                            $deger = $_POST['fiyat'];
                        }else{
                            $deger = '0';
                        }
                        $kaydet = $db->prepare("INSERT INTO pricing SET
                         dil=:dil,   
                         kat_id=:kat_id,
                         sira=:sira,
                         durum=:durum,
                         baslik=:baslik,
                         baslik_kat=:baslik_kat,
                         fiyat=:fiyat,
                         odeme_sure=:odeme_sure,
                         tavsiye=:tavsiye,
                         tavsiye_renk=:tavsiye_renk,
                         tavsiye_yazi_renk=:tavsiye_yazi_renk,
                         url_tur=:url_tur,
                         urun_id=:urun_id,
                         url_adres=:url_adres,
                         url_yazi=:url_yazi,
                         url_button=:url_button,
                         kutu_arkaplan=:kutu_arkaplan,
                         kutu_baslik_renk=:kutu_baslik_renk
                    ");
                        $sonuc = $kaydet->execute(array(
                            'dil' => $_SESSION['dil'],
                            'kat_id' => $_POST['parent_id'],
                            'sira' => $_POST['sira'],
                            'durum' => $_POST['durum'],
                            'baslik' => $_POST['baslik'],
                            'baslik_kat' => $_POST['baslik_kat'],
                            'fiyat' => $deger,
                            'odeme_sure' => $_POST['odeme_sure'],
                            'tavsiye' => $_POST['tavsiye'],
                            'tavsiye_renk' => colorFormat($_POST['tavsiye_renk']),
                            'tavsiye_yazi_renk' => colorFormat($_POST['tavsiye_yazi_renk']),
                            'url_tur' => $_POST['url_tur'],
                            'urun_id' => $_POST['urun_id'],
                            'url_adres' => $_POST['url_adres'],
                            'url_yazi' => $_POST['url_yazi'],
                            'url_button' => $_POST['url_button'],
                            'kutu_arkaplan' => colorFormat($_POST['kutu_arkaplan']),
                            'kutu_baslik_renk' => colorFormat($_POST['kutu_baslik_renk'])
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_list&parent='.$_POST['parent_id'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }

                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_list&parent='.$_POST['parent_id'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'table_edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['sira'] && $_POST['table_id'] && $_POST['parent_id'] ) {

                        if($_POST['fiyat'] == !null  ) {
                            $deger = $_POST['fiyat'];
                        }else{
                            $deger = '0';
                        }

                        $pricingCek = $db->prepare("select * from pricing where id=:id ");
                        $pricingCek->execute(array(
                            'id' => $_POST['table_id'],
                        ));
                        $pri = $pricingCek->fetch(PDO::FETCH_ASSOC);

                        if($_POST['urun_id'] == !null  ) {
                         $urunID = $_POST['urun_id'];
                        }else{
                            $urunID = $pri['urun_id'];
                        }

                        $guncelle = $db->prepare("UPDATE pricing SET
                         sira=:sira,
                         durum=:durum,
                         baslik=:baslik,
                         baslik_kat=:baslik_kat,
                         fiyat=:fiyat,
                         odeme_sure=:odeme_sure,
                         tavsiye=:tavsiye,
                         tavsiye_renk=:tavsiye_renk,
                         tavsiye_yazi_renk=:tavsiye_yazi_renk,
                         url_tur=:url_tur,
                         urun_id=:urun_id,
                         url_adres=:url_adres,
                         url_yazi=:url_yazi,
                         url_button=:url_button,
                         kutu_arkaplan=:kutu_arkaplan,
                         kutu_baslik_renk=:kutu_baslik_renk
                             WHERE id={$_POST['table_id']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'sira' => $_POST['sira'],
                            'durum' => $_POST['durum'],
                            'baslik' => $_POST['baslik'],
                            'baslik_kat' => $_POST['baslik_kat'],
                            'fiyat' => $deger,
                            'odeme_sure' => $_POST['odeme_sure'],
                            'tavsiye' => $_POST['tavsiye'],
                            'tavsiye_renk' => colorFormat($_POST['tavsiye_renk']),
                            'tavsiye_yazi_renk' => colorFormat($_POST['tavsiye_yazi_renk']),
                            'url_tur' => $_POST['url_tur'],
                            'urun_id' => $urunID,
                            'url_adres' => $_POST['url_adres'],
                            'url_yazi' => $_POST['url_yazi'],
                            'url_button' => $_POST['url_button'],
                            'kutu_arkaplan' => colorFormat($_POST['kutu_arkaplan']),
                            'kutu_baslik_renk' => colorFormat($_POST['kutu_baslik_renk'])
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_list&parent='.$_POST['parent_id'].'');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table_list&parent='.$_POST['parent_id'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'catadd'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['baslik'] && $_POST['sira']  ) {

                        if($_POST['seo_url'] == !null  ) {
                            $seo_url = seo($_POST['seo_url']);
                        }else{
                            $seo_url = seo($_POST['baslik']);
                        }

                        if($_POST['seo_baslik']==!null  ) {
                            $seo_title = $_POST['seo_baslik'];
                        }else{
                            $seo_title = $_POST['baslik'];
                        }
                        $sefLinkKontrol = $db->prepare("select * from pricing_kat where seo_url=:seo_url ");
                        $sefLinkKontrol->execute(array(
                            'seo_url' => $seo_url
                        ));
                        if($sefLinkKontrol->rowCount()<='0'  ) {
                            $kaydet = $db->prepare("INSERT INTO pricing_kat SET
                         dil=:dil,   
                         sira=:sira,
                         durum=:durum,
                         baslik=:baslik,
                         meta_desc=:meta_desc,
                         tags=:tags,
                         seo_url=:seo_url,
                         seo_baslik=:seo_baslik,
                         tab_durum=:tab_durum
                    ");
                            $sonuc = $kaydet->execute(array(
                                'dil' => $_SESSION['dil'],
                                'sira' => $_POST['sira'],
                                'durum' => $_POST['durum'],
                                'baslik' => $_POST['baslik'],
                                'meta_desc' => $_POST['meta_desc'],
                                'tags' => $_POST['tags'],
                                'seo_url' => $seo_url,
                                'seo_baslik' => $seo_title,
                                'tab_durum' => $_POST['tab_durum']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            $_SESSION['main_alert'] = 'seflink';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'catedit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['sira'] && $_POST['cat_id']  ) {

                        if($_POST['seo_url'] == !null  ) {
                            $seo_url = seo($_POST['seo_url']);
                        }else{
                            $seo_url = seo($_POST['baslik']);
                        }

                        if($_POST['seo_baslik']==!null  ) {
                            $seo_title = $_POST['seo_baslik'];
                        }else{
                            $seo_title = $_POST['baslik'];
                        }

                        $sefLinkKontrol = $db->prepare("select * from pricing_kat where seo_url=:seo_url ");
                        $sefLinkKontrol->execute(array(
                            'seo_url' => $seo_url
                        ));
                        if($sefLinkKontrol->rowCount()<='0'  ) {
                            $guncelle = $db->prepare("UPDATE pricing_kat SET
                                 sira=:sira,
                                 durum=:durum,
                                 baslik=:baslik,
                                 meta_desc=:meta_desc,
                                 tags=:tags,
                                 seo_url=:seo_url,
                                 seo_baslik=:seo_baslik,
                                 tab_durum=:tab_durum
                             WHERE id={$_POST['cat_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'sira' => $_POST['sira'],
                                'durum' => $_POST['durum'],
                                'baslik' => $_POST['baslik'],
                                'meta_desc' => $_POST['meta_desc'],
                                'tags' => $_POST['tags'],
                                'seo_url' => $seo_url,
                                'seo_baslik' => $seo_title,
                                'tab_durum' => $_POST['tab_durum']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            $_SESSION['main_alert'] = 'seflink';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pricing_table');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }




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