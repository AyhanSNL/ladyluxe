<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'comment_set' || $_GET['status'] == 'comment_process' || $_GET['status'] == 'comment_edit' || $_GET['status'] == 'category_add' || $_GET['status'] == 'variant_add'  || $_GET['status'] == 'variant_multidelete' || $_GET['status'] == 'variant_edit' || $_GET['status'] == 'variant_group_add' || $_GET['status'] == 'variant_group_edit'  || $_GET['status'] == 'variant_group_delete'  || $_GET['status'] == 'feature_group_add' || $_GET['status'] == 'feature_group_edit' || $_GET['status'] == 'feature_group_multidelete'  || $_GET['status'] == 'feature_add' || $_GET['status'] == 'feature_edit' || $_GET['status'] == 'feature_multidelete' || $_GET['status'] == 'ecatalog_add' || $_GET['status'] == 'ecatalog_edit' || $_GET['status'] == 'ecatalog_multidelete' || $_GET['status'] == 'brand_multidelete' || $_GET['status'] == 'brand_delete' || $_GET['status'] == 'brand_add' || $_GET['status'] == 'brand_edit' || $_GET['status'] == 'sub_category_delete'  || $_GET['status'] == 'subcategories_multidelete' || $_GET['status'] == 'sub_category_edit' || $_GET['status'] == 'sub_category_add' || $_GET['status'] == 'category_edit' || $_GET['status'] == 'categories_multidelete' || $_GET['status'] == 'category_delete' || $_GET['status'] == 'category_delete'  ) {

            if($_GET['status'] == 'comment_process') {
                if ($_POST) {
                    $IDler = $_POST['processID'];
                    if($IDler >'0'  ) {
                        $deleteName = trim(strip_tags($_POST['delete']));
                        $successName = trim(strip_tags($_POST['active']));
                        $noOnay = trim(strip_tags($_POST['pasive']));
                        $bekle = trim(strip_tags($_POST['noposition']));
                        if($deleteName == '1' || $successName == '1' || $noOnay == '1' || $bekle == '1'  ) {
                            /* Silme İşlemi */
                            if($deleteName == '1') {
                                foreach ($IDler as $ids) {
                                    $yorumSsql = $db->prepare("select * from urun_yorum where id=:id");
                                    $yorumSsql->execute(array(
                                        'id' => $ids
                                    ));
                                    if($yorumSsql->rowCount()>'0'  ) {
                                      $silmeislem = $db->prepare("DELETE from urun_yorum WHERE id=:id");
                                      $sil = $silmeislem->execute(array(
                                      'id' => $ids
                                      ));
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=products_comments');
                                }
                            }
                            /*  <========SON=========>>> Silme İşlemi SON */

                            /* Aktif et */
                            if($successName == '1') {
                               foreach ($IDler as $ids) {
                                   $yorumSsql = $db->prepare("select * from urun_yorum where id=:id");
                                   $yorumSsql->execute(array(
                                       'id' => $ids
                                   ));
                                   if($yorumSsql->rowCount()>'0'  ) {
                                        $guncelle = $db->prepare("UPDATE urun_yorum SET
                                                onay=:onay
                                         WHERE id={$ids}      
                                        ");
                                        $sonuc = $guncelle->execute(array(
                                            'onay' => '1'
                                        ));
                                   }
                                   $_SESSION['main_alert'] = 'success';
                                   header('Location:'.$ayar['panel_url'].'pages.php?page=products_comments');
                               }
                            }
                            /*  <========SON=========>>> Aktif et SON */

                            /* Pasif Et */
                            if($noOnay == '1') {
                                foreach ($IDler as $ids) {
                                    $yorumSsql = $db->prepare("select * from urun_yorum where id=:id");
                                    $yorumSsql->execute(array(
                                        'id' => $ids
                                    ));
                                    if($yorumSsql->rowCount()>'0'  ) {
                                        $guncelle = $db->prepare("UPDATE urun_yorum SET
                                                onay=:onay
                                         WHERE id={$ids}      
                                        ");
                                        $sonuc = $guncelle->execute(array(
                                            'onay' => '2'
                                        ));
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=products_comments');
                                }
                            }
                            /*  <========SON=========>>> Pasif Et SON */

                            /* Beklet */
                            if($bekle == '1') {
                                foreach ($IDler as $ids) {
                                    $yorumSsql = $db->prepare("select * from urun_yorum where id=:id");
                                    $yorumSsql->execute(array(
                                        'id' => $ids
                                    ));
                                    if($yorumSsql->rowCount()>'0'  ) {
                                        $guncelle = $db->prepare("UPDATE urun_yorum SET
                                                onay=:onay
                                         WHERE id={$ids}      
                                        ");
                                        $sonuc = $guncelle->execute(array(
                                            'onay' => '0'
                                        ));
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=products_comments');
                                }
                            }
                            /*  <========SON=========>>> Beklet SON */
                        }else{
                            echo "olamaz";
                        }
                    }else{
                        $_SESSION['main_alert'] = 'nocheck2';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=products_comments');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'comment_set') {
                if (isset($_POST['edit']) && $_POST) {
                    $guncelle = $db->prepare("UPDATE urun_detay SET
                            urun_yorum_onay=:urun_yorum_onay
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'urun_yorum_onay' => $_POST['urun_yorum_onay']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=products_comments');
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                }
            }

            if($_GET['status'] == 'comment_edit') {
                if (isset($_POST['edit']) && $_POST && $_POST['comment_id']) {
                    $sorguSql = $db->prepare("select * from urun_yorum where id=:id ");
                    $sorguSql->execute(array(
                        'id' => $_POST['comment_id']
                    ));
                    if($sorguSql->rowCount()>'0'  ) {
                        $guncelle = $db->prepare("UPDATE urun_yorum SET
                                baslik=:baslik,
                                yorum=:yorum,
                                yildiz=:yildiz,
                                gizli=:gizli,
                                onay=:onay
                         WHERE id={$_POST['comment_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                            'yorum' => $_POST['yorum'],
                            'yildiz' => $_POST['yildiz'],
                            'gizli' => $_POST['gizli'],
                            'onay' => $_POST['onay']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=products_comments');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'variant_group_add') {
                if (isset($_POST['add']) && $_POST) {
                    $kaydet = $db->prepare("INSERT INTO urun_varyant SET
                          baslik=:baslik, 
                          durum=:durum,
                          dil=:dil,
                          sira=:sira
                   ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'durum' => $_POST['durum'],
                        'dil' => $_SESSION['dil'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_variants');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'variant_group_edit') {
                if (isset($_POST['edit']) && $_POST && $_POST['group_id']) {
                    $guncelle = $db->prepare("UPDATE urun_varyant SET
                          baslik=:baslik, 
                          durum=:durum,
                          sira=:sira   
                     WHERE id={$_POST['group_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_variants');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'variant_group_delete') {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_variants');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler) {
                            $silmeislem = $db->prepare("DELETE from urun_varyant WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $idler
                            ));
                            $silmeislem = $db->prepare("DELETE from urun_varyant_ozellik WHERE var_id=:var_id");
                            $sil = $silmeislem->execute(array(
                                'var_id' => $idler
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_variants');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'variant_add') {
                if (isset($_POST['add']) && $_POST && $_POST['var_id']) {
                    $kaydet = $db->prepare("INSERT INTO urun_varyant_ozellik SET
                          baslik=:baslik, 
                          var_id=:var_id
                   ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'var_id' => $_POST['var_id']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_variants_list&parent='.$_POST['var_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'variant_edit') {
                if (isset($_POST['edit']) && $_POST && $_POST['var_id'] && $_POST['list_id']) {
                    $guncelle = $db->prepare("UPDATE urun_varyant_ozellik SET
                          baslik=:baslik
                     WHERE id={$_POST['list_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_variants_list&parent='.$_POST['var_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'variant_multidelete') {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_variants_list&parent='.$_POST['var_id'].'');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler) {
                            $silmeislem = $db->prepare("DELETE from urun_varyant_ozellik WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_variants_list&parent='.$_POST['var_id'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'feature_add') {
                if (isset($_POST['add']) && $_POST && $_POST['grup_id']) {
                    $kaydet = $db->prepare("INSERT INTO urun_ozellik SET
                          baslik=:baslik, 
                          grup_id=:grup_id,
                          sira=:sira
                   ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'grup_id' => $_POST['grup_id'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_features_list&parent='.$_POST['grup_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'feature_edit') {
                if (isset($_POST['edit']) && $_POST && $_POST['group_id'] && $_POST['list_id'] && $_POST['baslik'] && $_POST['sira']) {
                    $guncelle = $db->prepare("UPDATE urun_ozellik SET
                          baslik=:baslik, 
                          sira=:sira 
                     WHERE id={$_POST['list_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $guncelle = $db->prepare("UPDATE filtre_ozellik SET
                               sira=:sira 
                         WHERE ozellik_id={$_POST['list_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'sira' => $_POST['sira']
                        ));
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_features_list&parent='.$_POST['group_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'feature_multidelete') {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_features_list&parent='.$_POST['parent'].'');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler) {
                            $silmeislem = $db->prepare("DELETE from urun_ozellik WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_features_list&parent='.$_POST['parent'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'feature_group_edit') {
                if (isset($_POST['edit']) && $_POST && $_POST['group_id'] && $_POST['sira'] && $_POST['baslik']) {
                    $guncelle = $db->prepare("UPDATE urun_ozellik_grup SET
                          baslik=:baslik, 
                          durum=:durum,
                          sira=:sira   
                     WHERE id={$_POST['group_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira']
                    ));
                    if($sonuc){
                        $guncelle = $db->prepare("UPDATE filtre_ozellik_grup SET
                               sira=:sira 
                         WHERE kontrol={$_POST['group_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'sira' => $_POST['sira']
                        ));
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_features');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'feature_group_add') {
                if (isset($_POST['add']) && $_POST) {
                   $kaydet = $db->prepare("INSERT INTO urun_ozellik_grup SET
                          baslik=:baslik, 
                          durum=:durum,
                          sira=:sira
                   ");
                   $sonuc = $kaydet->execute(array(
                       'baslik' => $_POST['baslik'],
                       'durum' => $_POST['durum'],
                       'sira' => $_POST['sira']
                   ));
                   if($sonuc){
                       $_SESSION['main_alert'] = 'success';
                       header('Location:'.$ayar['panel_url'].'pages.php?page=product_features');
                   }else{
                   echo 'Veritabanı Hatası';
                   }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'feature_group_multidelete') {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_features');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler) {
                            $silmeislem = $db->prepare("DELETE from urun_ozellik_grup WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $idler
                            ));
                            $silmeislem = $db->prepare("DELETE from urun_ozellik WHERE grup_id=:grup_id");
                            $sil = $silmeislem->execute(array(
                                'grup_id' => $idler
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_features');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'ecatalog_edit') {
                if (isset($_POST['edit']) && $_POST && $_POST['catalog_id'] && $_POST['baslik'] && $_POST['dosya']) {
                    /* katalog Dosyası */
                    if ($_FILES['url']["size"] > 0) {
                        $file_format = $_FILES["url"];
                        $kaynak = $_FILES["url"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['url']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['url']['name']));
                        $filename = str_replace(' ', '_', $filename);
                        $filename = str_replace('ş', 's', $filename);
                        $filename = str_replace('&', '-', $filename);
                        $filename = str_replace('%', '-', $filename);
                        $filename = str_replace('?', '-', $filename);
                        $filename = str_replace('+', '-', $filename);
                        $filename = str_replace('ı', 'i', $filename);
                        $filename = str_replace('Ş', 's', $filename);
                        $filename = str_replace('ğ', 'g', $filename);
                        $filename = str_replace('Ğ', 'g', $filename);
                        $filename = str_replace('ü', 'u', $filename);
                        $filename = str_replace('Ü', 'u', $filename);
                        $filename = str_replace('ç', 'c', $filename);
                        $filename = str_replace('Ç', 'c', $filename);
                        $filename = str_replace('ö', 'o', $filename);
                        $filename = str_replace('Ö', 'o', $filename);
                        $filename = str_replace('İ', 'i', $filename);
                        $filename = preg_replace('/\s+/', '_', $filename);
                        $file_name_detay = $random . "-" . $random2 . "-" . $filename;
                        $target = "../i/e-catalog/" . $file_name_detay;

                        if ($file_format['type'] == 'application/pdf') {
                            $gitti = move_uploaded_file($kaynak, $target);
                            unlink('../i/e-catalog/'.$_POST['dosya'].'');
                            $mevcutFile = $file_name_detay;
                        }else{
                            $_SESSION['main_alert'] = 'filetype';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
                            exit();
                        }
                    }else{
                        $mevcutFile = $_POST['dosya'];
                    }
                    /*  <========SON=========>>> katalog Dosyası SON */
                    $guncelle = $db->prepare("UPDATE katalog SET
                         baslik=:baslik,   
                         url=:url      
                     WHERE id={$_POST['catalog_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'url' => $mevcutFile
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'ecatalog_add') {
                if (isset($_POST['add']) && $_POST && $_POST['baslik']) {
                    /* katalog Dosyası */
                    if ($_FILES['url']["size"] > 0) {
                        $file_format = $_FILES["url"];
                        $kaynak = $_FILES["url"]["tmp_name"];
                        $uzanti = explode(".", $_FILES['url']['name']);
                        $random = rand(0, (int)99999);
                        $random2 = rand(0, (int)999);
                        $filename = trim(addslashes($_FILES['url']['name']));
                        $filename = str_replace(' ', '_', $filename);
                        $filename = str_replace('ş', 's', $filename);
                        $filename = str_replace('&', '-', $filename);
                        $filename = str_replace('%', '-', $filename);
                        $filename = str_replace('?', '-', $filename);
                        $filename = str_replace('+', '-', $filename);
                        $filename = str_replace('ı', 'i', $filename);
                        $filename = str_replace('Ş', 's', $filename);
                        $filename = str_replace('ğ', 'g', $filename);
                        $filename = str_replace('Ğ', 'g', $filename);
                        $filename = str_replace('ü', 'u', $filename);
                        $filename = str_replace('Ü', 'u', $filename);
                        $filename = str_replace('ç', 'c', $filename);
                        $filename = str_replace('Ç', 'c', $filename);
                        $filename = str_replace('ö', 'o', $filename);
                        $filename = str_replace('Ö', 'o', $filename);
                        $filename = str_replace('İ', 'i', $filename);
                        $filename = preg_replace('/\s+/', '_', $filename);
                        $file_name_detay = $random . "-" . $random2 . "-" . $filename;
                        $target = "../i/e-catalog/" . $file_name_detay;

                        if ($file_format['type'] == 'application/pdf') {
                            $gitti = move_uploaded_file($kaynak, $target);
                        }else{
                            $_SESSION['main_alert'] = 'filetype';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
                            exit();
                        }
                    }else{
                        $_SESSION['main_alert'] = 'filesize';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
                        exit();
                    }
                    /*  <========SON=========>>> katalog Dosyası SON */
                    $kaydet = $db->prepare("INSERT INTO katalog SET
                         baslik=:baslik,   
                         url=:url,
                         dil=:dil
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'url' => $file_name_detay,
                        'dil' => $_SESSION['dil']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'ecatalog_multidelete'  ) {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler) {
                            $katralogCek = $db->prepare("select * from katalog ");
                            $katralogCek->execute(array(
                                'id' => $idler
                            ));
                            if($katralogCek->rowCount()>'0'  ) {
                                $kata = $katralogCek->fetch(PDO::FETCH_ASSOC);
                                unlink('../i/e-catalog/'.$kata['url'].'');
                            }
                            $silmeislem = $db->prepare("DELETE from katalog WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=e_catalog');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'brand_multidelete'  ) {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler) {
                            $markaSql = $db->prepare("select * from urun_marka where id=:id ");
                            $markaSql->execute(array(
                                'id' => $idler
                            ));
                            $markrow = $markaSql->fetch(PDO::FETCH_ASSOC);
                            unlink('../images/uploads/'.$markrow['gorsel'].'');
                            unlink('../images/uploads/'.$markrow['gorsel_anasayfa'].'');
                            $silmeislem = $db->prepare("DELETE from urun_marka WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'brand_delete'  ) {
                if (isset($_GET['no']) && $_GET['no'] > '0') {
                    $markaSql = $db->prepare("select * from urun_marka where id=:id ");
                    $markaSql->execute(array(
                        'id' => trim(strip_tags($_GET['no'])),
                    ));
                    if($markaSql<='0'  ) {
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                    $markrow = $markaSql->fetch(PDO::FETCH_ASSOC);
                    unlink('../images/uploads/'.$markrow['gorsel'].'');
                    unlink('../images/uploads/'.$markrow['gorsel_anasayfa'].'');
                    $silmeislem = $db->prepare("DELETE from urun_marka WHERE id=:id");
                    $sil = $silmeislem->execute(array(
                    'id' => trim(strip_tags($_GET['no']))
                    ));
                    if ($sil) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                    }else {
                    echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'brand_edit') {
                if (isset($_POST['brandEdit']) && $_POST) {
                    $markaSql = $db->prepare("select * from urun_marka where id=:id ");
                    $markaSql->execute(array(
                        'id' => trim(strip_tags($_POST['brand_id'])),
                    ));
                    if($markaSql<='0'  ) {
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }

                    if($_POST['seo_url'] == !null  ) {
                        $seo_url = seo($_POST['seo_url']);
                    }else{
                        $seo_url = seo($_POST['baslik']);
                    }

                    if($_POST['baslik_seo']==!null  ) {
                        $seo_title = $_POST['baslik_seo'];
                    }else{
                        $seo_title = $_POST['baslik'];
                    }


                    /* Görsel */
                    if ($_FILES['gorsel']["size"] > 0) {
                        $file_format = $_FILES["gorsel"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/gif' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                            /* Görsel Upload */
                            include_once('inc/class.upload.php');
                            $upload = new Upload($_FILES['gorsel']);
                            if ($upload->uploaded) {
                                $random = rand(0, (int)99991234569);
                                $random2 = rand(0, (int)999);
                                $upload->file_name_body_pre = 'brand_';
                                $upload->file_name_body_add = '' . $random . '' . $random2 . '';
                                $upload->image_resize = true;
                                $upload->png_quality = 90;
                                $upload->webp_quality = 90;
                                $upload->jpeg_quality = 90;
                                $upload->png_compression = 9;
                                $upload->image_y = 80;
                                $upload->image_ratio = true;
                                $upload->process("../images/uploads");
                                $file_name_detay = $upload->file_dst_name;
                            }
                            $gorsel1 = 'gonder';
                            /*  <========SON=========>>> Görsel Upload SON */
                        }else{
                            $_SESSION['main_alert'] = 'filetype';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                            exit();
                        }
                    }else{
                        $gorsel1 = 'yok';
                    }

                    if ($_FILES['gorsel_anasayfa']["size"] > 0) {
                        $file_format_home = $_FILES["gorsel_anasayfa"];
                        if ($file_format_home['type'] == 'image/jpeg' || $file_format_home['type'] == 'image/jpg' || $file_format_home['type'] == 'image/gif' ||  $file_format_home['type'] == 'image/png' || $file_format_home['type'] == 'image/webp' || $file_format_home['type'] == 'image/jxr' || $file_format_home['type'] == 'image/jp2' || $file_format_home['type'] == 'image/bmp' ) {
                            /* Görsel Upload */
                            include_once('inc/class.upload.php');
                            $upload = new Upload($_FILES['gorsel_anasayfa']);
                            if ($upload->uploaded) {
                                $random = rand(0, (int)99991234569);
                                $random2 = rand(0, (int)999);
                                $upload->file_name_body_pre = 'brand_home_';
                                $upload->file_name_body_add = ''.$random.''.$random2.'';
                                $upload->image_resize = true;
                                $upload->png_quality = 90;
                                $upload->webp_quality = 90;
                                $upload->jpeg_quality = 90;
                                $upload->png_compression = 9;
                                $upload->image_y = 80;
                                $upload->image_ratio = true;
                                $upload->process("../images/uploads");
                                $file_name_anasayfa = $upload->file_dst_name;
                            }
                            $gorsel2 = 'gonder';
                            /*  <========SON=========>>> Görsel Upload SON */
                        }else{
                            $_SESSION['main_alert'] = 'filetype';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                            exit();
                        }
                    }else{
                        $gorsel2 = 'yok';
                    }
                    /*  <========SON=========>>> Görsel SON */


                    if($gorsel1 == 'gonder'  ) {
                        $gorsel = $file_name_detay;
                        unlink('../images/uploads/'.$_POST['gorsel_old'].'');
                    }
                    if($gorsel1 == 'yok'  ) {
                        $gorsel = $_POST['gorsel_old'];
                    }

                    if($gorsel2 == 'gonder'  ) {
                        $gorsel_home = $file_name_anasayfa;
                        unlink('../images/uploads/'.$_POST['gorsel_anasayfa_old'].'');
                    }
                    if($gorsel2 == 'yok'  ) {
                        $gorsel_home = $_POST['gorsel_anasayfa_old'];
                    }

                    $guncelle = $db->prepare("UPDATE urun_marka SET
                         baslik=:baslik,   
                         baslik_seo=:baslik_seo,
                         seo_url=:seo_url,
                         gorsel=:gorsel,
                         gorsel_anasayfa=:gorsel_anasayfa,
                         spot=:spot,
                         sira=:sira,
                         durum=:durum,
                         anasayfa=:anasayfa,
                         tags=:tags,
                         meta_desc=:meta_desc    
                     WHERE id={$_POST['brand_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'baslik_seo' => $seo_title,
                        'seo_url' => $seo_url,
                        'gorsel' => $gorsel,
                        'gorsel_anasayfa' => $gorsel_home,
                        'spot' => $_POST['spot'],
                        'sira' => $_POST['sira'],
                        'durum' => $_POST['durum'],
                        'anasayfa' => $_POST['anasayfa'],
                        'tags' => $_POST['tags'],
                        'meta_desc' => $_POST['meta_desc'],
                    ));
                    if($sonuc){
                        $guncelle = $db->prepare("UPDATE urun SET
                                marka_sira
                         WHERE marka={$_POST['brand_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'marka_sira' => $_POST['sira']
                        ));
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }
            }
            if($_GET['status'] == 'brand_add'  ) {
                if (isset($_POST['brandAdd']) && $_POST) {

                    if($_POST['seo_url'] == !null  ) {
                        $seo_url = seo($_POST['seo_url']);
                    }else{
                        $seo_url = seo($_POST['baslik']);
                    }

                    if($_POST['baslik_seo']==!null  ) {
                        $seo_title = $_POST['baslik_seo'];
                    }else{
                        $seo_title = $_POST['baslik'];
                    }
                    
                    /* Görsel */
                    if ($_FILES['gorsel']["size"] > 0 && $_FILES['gorsel_anasayfa']["size"] > 0) {
                        $file_format = $_FILES["gorsel"];
                        $file_format_home = $_FILES["gorsel_anasayfa"];
                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/gif' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                            if ($file_format_home['type'] == 'image/jpeg' || $file_format_home['type'] == 'image/jpg' || $file_format_home['type'] == 'image/gif' ||  $file_format_home['type'] == 'image/png' || $file_format_home['type'] == 'image/webp' || $file_format_home['type'] == 'image/jxr' || $file_format_home['type'] == 'image/jp2' || $file_format_home['type'] == 'image/bmp' ) {
                                /* Görsel Upload */
                                include_once('inc/class.upload.php');
                                $upload = new Upload($_FILES['gorsel']);
                                if ($upload->uploaded) {
                                    $random = rand(0, (int)99991234569);
                                    $random2 = rand(0, (int)999);
                                    $upload->file_name_body_pre = 'brand_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 90;
                                    $upload->jpeg_quality = 90;
                                    $upload->png_compression = 9;
                                    $upload->image_y = 80;
                                    $upload->image_ratio = true;
                                    $upload->process("../images/uploads");
                                    $file_name_detay = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel Upload SON */

                                /* Görsel HOME Upload */
                                $upload = new Upload($_FILES['gorsel_anasayfa']);
                                if ($upload->uploaded) {
                                    $upload->file_name_body_pre = 'brand_home_';
                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                    $upload->image_resize = true;
                                    $upload->png_quality = 90;
                                    $upload->webp_quality = 90;
                                    $upload->jpeg_quality = 90;
                                    $upload->png_compression = 9;
                                    $upload->image_y = 80;
                                    $upload->image_ratio = true;
                                    $upload->process("../images/uploads");
                                    $file_name_anasayfa = $upload->file_dst_name;
                                }
                                /*  <========SON=========>>> Görsel HOME Upload SON */
                            }else{
                                $_SESSION['main_alert'] = 'filetype';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                                exit();
                            }
                            $gorsel1 = 'gonder';
                            $gorsel2 = 'gonder';
                        }else{
                            $_SESSION['main_alert'] = 'filetype';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                            exit();
                        }
                    }else{
                        $_SESSION['main_alert'] = 'filesize';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                        exit();
                    }
                    /*  <========SON=========>>> Görsel SON */


                    if($gorsel1 == 'gonder'  ) {
                        $gorsel = $file_name_detay;
                    }

                    if($gorsel2 == 'gonder'  ) {
                        $gorsel_home = $file_name_anasayfa;
                    }

                    
                    $kaydet = $db->prepare("INSERT INTO urun_marka SET
                         baslik=:baslik,   
                         baslik_seo=:baslik_seo,
                         seo_url=:seo_url,
                         gorsel=:gorsel,
                         gorsel_anasayfa=:gorsel_anasayfa,
                         spot=:spot,
                         sira=:sira,
                         durum=:durum,
                         anasayfa=:anasayfa,
                         tags=:tags,
                         meta_desc=:meta_desc
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'baslik_seo' => $seo_title,
                        'seo_url' => $seo_url,
                        'gorsel' => $gorsel,
                        'gorsel_anasayfa' => $gorsel_home,
                        'spot' => $_POST['spot'],
                        'sira' => $_POST['sira'],
                        'durum' => $_POST['durum'],
                        'anasayfa' => $_POST['anasayfa'],
                        'tags' => $_POST['tags'],
                        'meta_desc' => $_POST['meta_desc'],
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=brands');
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                }
            }

            if($_GET['status'] == 'sub_category_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] >'0'  ) {
                    $sorgu = $db->prepare("select * from urun_cat where id='$_GET[no]' ");
                    $sorgu->execute();
                    if($sorgu->rowCount()>'0'  ) {
                        $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                        $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                        $sil = $silmeislem->execute(array(
                            'id' => $row['id']
                        ));
                        if ($sil) {
                            $sorguSub1 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                            $sorguSub1->execute(array(
                                'ust_id' => $_GET['no'],
                            ));
                            foreach ($sorguSub1 as $sorgu1){
                                $sorguSub2 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                $sorguSub2->execute(array(
                                    'ust_id' => $sorgu1['id'],
                                ));
                                $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                $sil = $silmeislem->execute(array(
                                    'id' => $sorgu1['id']
                                ));
                                foreach ($sorguSub2 as $sorgu2){
                                    $sorguSub3 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                    $sorguSub3->execute(array(
                                        'ust_id' => $sorgu2['id'],
                                    ));
                                    $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                    $sil = $silmeislem->execute(array(
                                        'id' => $sorgu2['id']
                                    ));
                                    foreach ($sorguSub3 as $sorgu3){
                                        $sorguSub4 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                        $sorguSub4->execute(array(
                                            'ust_id' => $sorgu3['id'],
                                        ));
                                        $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                        $sil = $silmeislem->execute(array(
                                            'id' => $sorgu3['id']
                                        ));
                                    }
                                }

                            }
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=sub_categories&parent='.$_GET['parent'].'');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'subcategories_multidelete'  ) {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=sub_categories&parent='.$_POST['parent'].'');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler){
                            $sorgu = $db->prepare("select * from urun_cat where id='$idler' ");
                            $sorgu->execute();
                            if($sorgu->rowCount()>'0'  ) {
                                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                                $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                $sil = $silmeislem->execute(array(
                                    'id' => $row['id']
                                ));
                                if ($sil) {
                                    $sorguSub1 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                    $sorguSub1->execute(array(
                                        'ust_id' => $idler,
                                    ));
                                    foreach ($sorguSub1 as $sorgu1){
                                        $sorguSub2 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                        $sorguSub2->execute(array(
                                            'ust_id' => $sorgu1['id'],
                                        ));
                                        $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                        $sil = $silmeislem->execute(array(
                                            'id' => $sorgu1['id']
                                        ));
                                        foreach ($sorguSub2 as $sorgu2){
                                            $sorguSub3 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                            $sorguSub3->execute(array(
                                                'ust_id' => $sorgu2['id'],
                                            ));
                                            $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                            $sil = $silmeislem->execute(array(
                                                'id' => $sorgu2['id']
                                            ));
                                            foreach ($sorguSub3 as $sorgu3){
                                                $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                                $sil = $silmeislem->execute(array(
                                                    'id' => $sorgu3['id']
                                                ));
                                            }
                                        }
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=sub_categories&parent='.$_POST['parent'].'');
                                }
                            }
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'category_delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] >'0'  ) {
                    $sorgu = $db->prepare("select * from urun_cat where id='$_GET[no]' ");
                    $sorgu->execute();
                    if($sorgu->rowCount()>'0'  ) {
                        $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                        $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                        $sil = $silmeislem->execute(array(
                            'id' => $row['id']
                        ));
                        if ($sil) {
                            $sorguSub1 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                            $sorguSub1->execute(array(
                                'ust_id' => $_GET['no'],
                            ));
                            foreach ($sorguSub1 as $sorgu1){
                                $sorguSub2 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                $sorguSub2->execute(array(
                                    'ust_id' => $sorgu1['id'],
                                ));
                                $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                $sil = $silmeislem->execute(array(
                                    'id' => $sorgu1['id']
                                ));
                                foreach ($sorguSub2 as $sorgu2){
                                    $sorguSub3 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                    $sorguSub3->execute(array(
                                        'ust_id' => $sorgu2['id'],
                                    ));
                                    $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                    $sil = $silmeislem->execute(array(
                                        'id' => $sorgu2['id']
                                    ));
                                    foreach ($sorguSub3 as $sorgu3){
                                        $sorguSub4 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                        $sorguSub4->execute(array(
                                            'ust_id' => $sorgu3['id'],
                                        ));
                                        $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                        $sil = $silmeislem->execute(array(
                                            'id' => $sorgu3['id']
                                        ));
                                        foreach ($sorguSub4 as $sorgu4){
                                            $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                            $sil = $silmeislem->execute(array(
                                                'id' => $sorgu4['id']
                                            ));
                                        }
                                    }
                                }

                            }
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=categories');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'categories_multidelete'  ) {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=categories');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler){
                            $sorgu = $db->prepare("select * from urun_cat where id='$idler' ");
                            $sorgu->execute();
                            if($sorgu->rowCount()>'0'  ) {
                                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                                $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                $sil = $silmeislem->execute(array(
                                    'id' => $row['id']
                                ));
                                if ($sil) {
                                    $sorguSub1 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                    $sorguSub1->execute(array(
                                        'ust_id' => $idler,
                                    ));
                                    foreach ($sorguSub1 as $sorgu1){
                                        $sorguSub2 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                        $sorguSub2->execute(array(
                                            'ust_id' => $sorgu1['id'],
                                        ));
                                        $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                        $sil = $silmeislem->execute(array(
                                            'id' => $sorgu1['id']
                                        ));
                                        foreach ($sorguSub2 as $sorgu2){
                                            $sorguSub3 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                            $sorguSub3->execute(array(
                                                'ust_id' => $sorgu2['id'],
                                            ));
                                            $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                            $sil = $silmeislem->execute(array(
                                                'id' => $sorgu2['id']
                                            ));
                                            foreach ($sorguSub3 as $sorgu3){
                                                $sorguSub4 = $db->prepare("select * from urun_cat where ust_id=:ust_id ");
                                                $sorguSub4->execute(array(
                                                    'ust_id' => $sorgu3['id'],
                                                ));
                                                $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                                $sil = $silmeislem->execute(array(
                                                    'id' => $sorgu3['id']
                                                ));
                                                foreach ($sorguSub4 as $sorgu4){
                                                    $silmeislem = $db->prepare("DELETE from urun_cat WHERE id=:id");
                                                    $sil = $silmeislem->execute(array(
                                                        'id' => $sorgu4['id']
                                                    ));
                                                }
                                            }
                                        }

                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=categories');
                                }
                            }
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'category_add'  ) {
                if(isset($_POST['catAdd']) && $_POST  ) {

                    if($_POST['seo_url'] == !null  ) {
                        $seo_url = seo($_POST['seo_url']);
                    }else{
                        $seo_url = seo($_POST['baslik']);
                    }

                    if($_POST['baslik_seo']==!null  ) {
                        $seo_title = $_POST['baslik_seo'];
                    }else{
                        $seo_title = $_POST['baslik'];
                    }
                    
                    $kaydet = $db->prepare("INSERT INTO urun_cat SET
                        baslik=:baslik,    
                        durum=:durum,
                        spot=:spot,
                        tags=:tags,
                        meta_desc=:meta_desc,
                        ust_id=:ust_id,
                        dil=:dil,
                        seo_url=:seo_url,
                        baslik_seo=:baslik_seo,
                        sira=:sira,
                        marka_filtre=:marka_filtre,
                        ozellik_filtre=:ozellik_filtre,
                        fiyat_filtre=:fiyat_filtre
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'durum' => $_POST['durum'],
                        'spot' => $_POST['spot'],
                        'tags' => $_POST['tags'],
                        'meta_desc' => $_POST['meta_desc'],
                        'ust_id' => '0',
                        'dil' => $_SESSION['dil'],
                        'seo_url' => $seo_url,
                        'baslik_seo' => $seo_title,
                        'sira' => $_POST['sira'],
                        'marka_filtre' => $_POST['marka_filtre'],
                        'ozellik_filtre' => $_POST['ozellik_filtre'],
                        'fiyat_filtre' => $_POST['fiyat_filtre']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=categories');
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'category_edit'  ) {
                if (isset($_POST['catEdit']) && $_POST) {
                    if($_POST['cat_id']  ) {
                        $katSql = $db->prepare("select * from urun_cat where id=:id ");
                        $katSql->execute(array(
                            'id' => $_POST['cat_id']
                        ));
                        if($katSql->rowCount()>'0'  ) {

                            if($_POST['seo_url'] == !null  ) {
                                $seo_url = seo($_POST['seo_url']);
                            }else{
                                $seo_url = seo($_POST['baslik']);
                            }

                            if($_POST['baslik_seo']==!null  ) {
                                $seo_title = $_POST['baslik_seo'];
                            }else{
                                $seo_title = $_POST['baslik'];
                            }


                            $guncelle = $db->prepare("UPDATE urun_cat SET
                                    baslik=:baslik,
                                    sira=:sira,
                                    baslik_seo=:baslik_seo,
                                    seo_url=:seo_url,
                                    meta_desc=:meta_desc,
                                    tags=:tags,
                                    durum=:durum,
                                    ozellik_filtre=:ozellik_filtre,
                                    marka_filtre=:marka_filtre,
                                    fiyat_filtre=:fiyat_filtre,
                                    spot=:spot
                             WHERE id={$_POST['cat_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'sira' => $_POST['sira'],
                                'baslik_seo' => $seo_title,
                                'seo_url' => $seo_url,
                                'meta_desc' => $_POST['meta_desc'],
                                'tags' => $_POST['tags'],
                                'durum' => $_POST['durum'],
                                'ozellik_filtre' => $_POST['ozellik_filtre'],
                                'marka_filtre' => $_POST['marka_filtre'],
                                'fiyat_filtre' => $_POST['fiyat_filtre'],
                                'spot' => $_POST['spot']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=categories');
                            }else{
                            echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'sub_category_add'  ) {
                if(isset($_POST['subcatAdd']) && $_POST ) {

                    if($_POST['seo_url'] == !null  ) {
                        $seo_url = seo($_POST['seo_url']);
                    }else{
                        $seo_url = seo($_POST['baslik']);
                    }

                    if($_POST['baslik_seo']==!null  ) {
                        $seo_title = $_POST['baslik_seo'];
                    }else{
                        $seo_title = $_POST['baslik'];
                    }

                    $kaydet = $db->prepare("INSERT INTO urun_cat SET
                        baslik=:baslik,    
                        durum=:durum,
                        spot=:spot,
                        tags=:tags,
                        meta_desc=:meta_desc,
                        ust_id=:ust_id,
                        dil=:dil,
                        seo_url=:seo_url,
                        baslik_seo=:baslik_seo,
                        sira=:sira,
                        marka_filtre=:marka_filtre,
                        ozellik_filtre=:ozellik_filtre,
                        fiyat_filtre=:fiyat_filtre
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'durum' => $_POST['durum'],
                        'spot' => $_POST['spot'],
                        'tags' => $_POST['tags'],
                        'meta_desc' => $_POST['meta_desc'],
                        'ust_id' => $_POST['parent_id'],
                        'dil' => $_SESSION['dil'],
                        'seo_url' => $seo_url,
                        'baslik_seo' => $seo_title,
                        'sira' => $_POST['sira'],
                        'marka_filtre' => $_POST['marka_filtre'],
                        'ozellik_filtre' => $_POST['ozellik_filtre'],
                        'fiyat_filtre' => $_POST['fiyat_filtre']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sub_categories&parent='.$_POST['parent_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }


                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'sub_category_edit'  ) {
                if (isset($_POST['subcatEdit']) && $_POST) {
                    if($_POST['cat_id']  ) {
                        $katSql = $db->prepare("select * from urun_cat where id=:id ");
                        $katSql->execute(array(
                            'id' => $_POST['cat_id']
                        ));
                        if($katSql->rowCount()>'0'  ) {

                            if($_POST['seo_url'] == !null  ) {
                                $seo_url = seo($_POST['seo_url']);
                            }else{
                                $seo_url = seo($_POST['baslik']);
                            }

                            if($_POST['baslik_seo']==!null  ) {
                                $seo_title = $_POST['baslik_seo'];
                            }else{
                                $seo_title = $_POST['baslik'];
                            }

                            $guncelle = $db->prepare("UPDATE urun_cat SET
                                    baslik=:baslik,
                                    sira=:sira,
                                    baslik_seo=:baslik_seo,
                                    seo_url=:seo_url,
                                    meta_desc=:meta_desc,
                                    tags=:tags,
                                    durum=:durum,
                                    ozellik_filtre=:ozellik_filtre,
                                    marka_filtre=:marka_filtre,
                                    fiyat_filtre=:fiyat_filtre,
                                    spot=:spot
                             WHERE id={$_POST['cat_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'sira' => $_POST['sira'],
                                'baslik_seo' => $seo_title,
                                'seo_url' => $seo_url,
                                'meta_desc' => $_POST['meta_desc'],
                                'tags' => $_POST['tags'],
                                'durum' => $_POST['durum'],
                                'ozellik_filtre' => $_POST['ozellik_filtre'],
                                'marka_filtre' => $_POST['marka_filtre'],
                                'fiyat_filtre' => $_POST['fiyat_filtre'],
                                'spot' => $_POST['spot']
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=sub_categories&parent='.$_POST['parent_id'].'');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
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