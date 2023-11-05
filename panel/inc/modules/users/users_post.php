<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'user_add' || $_GET['status'] == 'noti_sms' || $_GET['status'] == 'noti_email' || $_GET['status'] == 'page_reset' || $_GET['status'] == 'user_delete' || $_GET['status'] == 'page_text_update' || $_GET['status'] == 'page_text_insert' || $_GET['status'] == 'settings_update' || $_GET['status'] == 'group_add'  || $_GET['status'] == 'ticket_status_update' || $_GET['status'] == 'group_status_update' || $_GET['status'] == 'group_delete' || $_GET['status'] == 'group_edit' ||  $_GET['status'] == 'user_edit' || $_GET['status'] == 'settings' || $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete') {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            $timestamp = date('Y-m-d G:i:s');
            $timestamp2 = date('Y-m-d');
            /* Address Reset db */
            if($_GET['status'] == 'page_reset'  ) {
                if (isset($_GET['ok']) && $_GET['ok'] == 'ok') {
                    $silmeislem = $db->prepare("DELETE from ziyaretciler_adres ");
                    $silmeislem->execute();
                    if ($silmeislem) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=visitor_analytics');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Address Reset db SON */

            /* Text Update */
            if($_GET['status'] == 'page_text_update'  ) {
                if ($_POST && isset($_POST['update'])) {
                    $guncelle = $db->prepare("UPDATE uyeler_yazilar SET
                                 register_text=:register_text,
                                 login_text=:login_text
                         WHERE id={$_POST['text_id']}     
                        ");
                    $sonuc = $guncelle->execute(array(
                        'register_text' => $_POST['register_text'],
                        'login_text' => $_POST['login_text']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users_settings');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Text Update SON */

            /* Text nssert */
            if($_GET['status'] == 'page_text_insert'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    $kaydet = $db->prepare("INSERT INTO uyeler_yazilar SET
                             register_text=:register_text,
                             dil=:dil,
                                 login_text=:login_text   
                    ");
                    $sonuc = $kaydet->execute(array(
                        'register_text' => $_POST['register_text'],
                        'dil' => $_SESSION['dil'],
                        'login_text' => $_POST['login_text']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users_settings');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Text nssert SON */

            /* User Settings */
            if($_GET['status'] == 'settings_update'  ) {
                if ($_POST && isset($_POST['update'])) {
                    $guncelle = $db->prepare("UPDATE uyeler_ayar SET
                                 durum=:durum,
                                 yeni_uyelik=:yeni_uyelik,
                                 oto_onay=:oto_onay,
                                 basit_form=:basit_form,
                                 uye_tip_zorunlu=:uye_tip_zorunlu,
                                 sms_ekle=:sms_ekle,
                                 eposta_ekle=:eposta_ekle,
                                 adres_alani=:adres_alani,
                                 destek_alani=:destek_alani,
                                 destek_siparis_mecbur=:destek_siparis_mecbur,
                                 siparisler_alani=:siparisler_alani,
                                 yorumlar_alani=:yorumlar_alani,
                                 favori_alani=:favori_alani,
                                 kupon_alani=:kupon_alani,
                                 iptal_alani=:iptal_alani
                         WHERE id='1'      
                        ");
                    $sonuc = $guncelle->execute(array(
                        'durum' => $_POST['durum'],
                        'yeni_uyelik' => $_POST['yeni_uyelik'],
                        'oto_onay' => $_POST['oto_onay'],
                        'basit_form' => $_POST['basit_form'],
                        'uye_tip_zorunlu' => $_POST['uye_tip_zorunlu'],
                        'sms_ekle' => $_POST['sms_ekle'],
                        'eposta_ekle' => $_POST['eposta_ekle'],
                        'adres_alani' => $_POST['adres_alani'],
                        'destek_alani' => $_POST['destek_alani'],
                        'destek_siparis_mecbur' => $_POST['destek_siparis_mecbur'],
                        'siparisler_alani' => $_POST['siparisler_alani'],
                        'yorumlar_alani' => $_POST['yorumlar_alani'],
                        'favori_alani' => $_POST['favori_alani'],
                        'kupon_alani' => $_POST['kupon_alani'],
                        'iptal_alani' => $_POST['iptal_alani'],
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users_settings');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> User Settings SON */

            /* Ticket_User Set */
            if($_GET['status'] == 'ticket_status_update'  ) {
                if ($_POST && isset($_POST['update'])) {
                    $guncelle = $db->prepare("UPDATE uyeler SET
                                 destek=:destek,
                                 destek_sure_2=:destek_sure_2
                         WHERE id={$_POST['user_id']}      
                        ");
                    $sonuc = $guncelle->execute(array(
                        'destek' => $_POST['destek'],
                        'destek_sure_2' => $_POST['destek_sure_2']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Ticket_User Set SON */

            /* Group Time */
            if($_GET['status'] == 'group_status_update'  ) {
                if ($_POST && isset($_POST['update'])) {
                    $guncelle = $db->prepare("UPDATE uyeler SET
                                 uye_grup_sure_durum=:uye_grup_sure_durum,
                                 uye_grup_sure_2=:uye_grup_sure_2
                         WHERE id={$_POST['user_id']}      
                        ");
                    $sonuc = $guncelle->execute(array(
                        'uye_grup_sure_durum' => $_POST['uye_grup_sure_durum'],
                        'uye_grup_sure_2' => $_POST['uye_grup_sure_2']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Group Time SON */

            /* Group Add */
            if($_GET['status'] == 'group_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['baslik']) {
                        if($_POST['indirim_oran'] == null || $_POST['indirim_oran'] == ''  ) {
                         $indOran = '0';
                        }else{
                            $indOran = $_POST['indirim_oran'];
                        }
                        $kaydet = $db->prepare("INSERT INTO uyeler_grup SET
                                    baslik=:baslik,
                                    ozel_indirim=:ozel_indirim,
                                    indirim_oran=:indirim_oran,
                                    fiyat_tip=:fiyat_tip
                            ");
                        $sonuc = $kaydet->execute(array(
                            'baslik' => $_POST['baslik'],
                            'ozel_indirim' => $_POST['ozel_indirim'],
                            'indirim_oran' => $indOran,
                            'fiyat_tip' => $_POST['fiyat_tip']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=users_group');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users_group');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Group Add SON */

            /* Group Edit */
            if($_GET['status'] == 'group_edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if ($_POST['baslik']) {
                        $guncelle = $db->prepare("UPDATE uyeler_grup SET
                                    baslik=:baslik,
                                    ozel_indirim=:ozel_indirim,
                                    indirim_oran=:indirim_oran,
                                    fiyat_tip=:fiyat_tip
                         WHERE id={$_POST['g_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'ozel_indirim' => $_POST['ozel_indirim'],
                            'indirim_oran' => $_POST['indirim_oran'],
                            'fiyat_tip' => $_POST['fiyat_tip']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=users_group');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users_group');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Group Edit SON */

            /* Group Delete */
            if($_GET['status'] == 'group_delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from uyeler_grup where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from uyeler_grup WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=users_group');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users_group');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Group Delete SON */

            /*  Add */
            if($_GET['status'] == 'user_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if ($_POST['isim'] && $_POST['soyisim'] && $_POST['eposta'] && $_POST['sifre'] )  {
                        if (filter_var($_POST['eposta'], FILTER_VALIDATE_EMAIL)){

                            $userCnter = $db->prepare("select * from uyeler where eposta=:eposta ");
                            $userCnter->execute(array(
                                'eposta' => $_POST['eposta']
                            ));

                            if($userCnter->rowCount()<='0'  ) {
                                $sifre = md5($_POST['sifre']);
                                $kaydet = $db->prepare("INSERT INTO uyeler SET
                                    isim=:isim,
                                    tarih=:tarih,
                                    eposta_durum=:eposta_durum,
                                    sms_durum=:sms_durum,
                                    destek=:destek,
                                    tarih_ymd=:tarih_ymd,
                                    soyisim=:soyisim,
                                    eposta=:eposta,
                                    uyesifre=:uyesifre,
                                    uye_grup=:uye_grup,
                                    onay=:onay,
                                    uye_tip=:uye_tip
                                            ");
                                $sonuc = $kaydet->execute(array(
                                    'isim' => $_POST['isim'],
                                    'tarih' => $timestamp,
                                    'eposta_durum' => '2',
                                    'sms_durum' => '2',
                                    'destek' => '1',
                                    'tarih_ymd' => $timestamp2,
                                    'soyisim' => $_POST['soyisim'],
                                    'eposta' => $_POST['eposta'],
                                    'uyesifre' => $sifre,
                                    'uye_grup' => $_POST['uye_grup'],
                                    'onay' => '1',
                                    'uye_tip' => $_POST['tip']
                                ));
                                if($sonuc){
                                    if($ayar['smtp_durum'] == '1' && $_POST['bildirim']== '1' ) {
                                        $eposta = $_POST['eposta'];
                                        $duzsifre = $_POST['sifre'];
                                        $isim = $_POST['isim'];
                                        $soyisim = $_POST['soyisim'];
                                        $bilgiler = $_POST['bildirim_bilgiler'];
                                        include 'inc/modules/users/user_information_email.php';
                                    }
                                    $_SESSION['main_alert'] = 'success';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                            }else{
                                $_SESSION['main_alert'] = 'emailhave';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                            }

                        }else{
                            $_SESSION['main_alert'] = 'emailerror';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  Edit */
            if($_GET['status'] == 'user_edit'  ) {
                if ($_POST && isset($_POST['update'])) {
                    if($_POST['isim'] && $_POST['soyisim'] && $_POST['user_id'] && $_POST['eposta']) {

                        $sorguEposta = $db->prepare("select * from uyeler where eposta=:eposta ");
                        $sorguEposta->execute(array(
                            'eposta' => $_POST['eposta']
                        ));
                        $epostaRow = $sorguEposta->fetch(PDO::FETCH_ASSOC);

                        if($sorguEposta->rowCount()<='0'  ) {
                            if (filter_var($_POST['eposta'], FILTER_VALIDATE_EMAIL)){
                                if($_POST['sifre'] == !null  ) {
                                    /* Şifre değiştiriliyor */
                                    $sifre = trim(strip_tags($_POST['sifre']));
                                    $mdSifre = md5($sifre);
                                    $guncelle = $db->prepare("UPDATE uyeler SET
                                       isim=:isim,     
                                       soyisim=:soyisim,
                                       telefon=:telefon,
                                       eposta=:eposta,
                                       uye_tip=:uye_tip,
                                       firma_unvan=:firma_unvan,
                                       tc_no=:tc_no,
                                       vergi_dairesi=:vergi_dairesi,
                                       vergi_no=:vergi_no,
                                       uyesifre=:uyesifre,
                                       uye_grup=:uye_grup,
                                       onay=:onay
                                     WHERE id={$_POST['user_id']}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'isim' => $_POST['isim'],
                                        'soyisim' => $_POST['soyisim'],
                                        'telefon' => $_POST['telefon'],
                                        'eposta' => $_POST['eposta'],
                                        'uye_tip' => $_POST['tip'],
                                        'firma_unvan' => $_POST['firma_unvan'],
                                        'tc_no' => $_POST['tc'],
                                        'vergi_dairesi' => $_POST['vergi_dairesi'],
                                        'vergi_no' => $_POST['vergi_no'],
                                        'uyesifre' => $mdSifre,
                                        'uye_grup' => $_POST['uye_grup'],
                                        'onay' => $_POST['onay']
                                    ));
                                    if($sonuc){
                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                    /*  <========SON=========>>> Şifre değiştiriliyor SON */
                                }else{
                                    /* Eski Şifre */
                                    $guncelle = $db->prepare("UPDATE uyeler SET
                                       isim=:isim,     
                                       soyisim=:soyisim,
                                       telefon=:telefon,
                                       eposta=:eposta,
                                       uye_tip=:uye_tip,
                                       firma_unvan=:firma_unvan,
                                       tc_no=:tc_no,
                                       vergi_dairesi=:vergi_dairesi,
                                       vergi_no=:vergi_no,
                                       uye_grup=:uye_grup,
                                       onay=:onay
                                     WHERE id={$_POST['user_id']}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'isim' => $_POST['isim'],
                                        'soyisim' => $_POST['soyisim'],
                                        'telefon' => $_POST['telefon'],
                                        'eposta' => $_POST['eposta'],
                                        'uye_tip' => $_POST['tip'],
                                        'firma_unvan' => $_POST['firma_unvan'],
                                        'tc_no' => $_POST['tc'],
                                        'vergi_dairesi' => $_POST['vergi_dairesi'],
                                        'vergi_no' => $_POST['vergi_no'],
                                        'uye_grup' => $_POST['uye_grup'],
                                        'onay' => $_POST['onay']
                                    ));
                                    if($sonuc){
                                        $_SESSION['main_alert'] = 'success';
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                    /*  <========SON=========>>> Eski Şifre SON */
                                }
                            }else{
                                $_SESSION['main_alert'] = 'emailerror';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                            }
                        }else{
                            if($epostaRow['id'] == $_POST['user_id'] ) {
                                if (filter_var($_POST['eposta'], FILTER_VALIDATE_EMAIL)){
                                    if($_POST['sifre'] == !null  ) {
                                        /* Şifre değiştiriliyor */
                                        $sifre = trim(strip_tags($_POST['sifre']));
                                        $mdSifre = md5($sifre);
                                        $guncelle = $db->prepare("UPDATE uyeler SET
                                       isim=:isim,     
                                       soyisim=:soyisim,
                                       telefon=:telefon,
                                       eposta=:eposta,
                                       uye_tip=:uye_tip,
                                       firma_unvan=:firma_unvan,
                                       tc_no=:tc_no,
                                       vergi_dairesi=:vergi_dairesi,
                                       vergi_no=:vergi_no,
                                       uyesifre=:uyesifre,
                                       uye_grup=:uye_grup,
                                       onay=:onay
                                     WHERE id={$_POST['user_id']}      
                                    ");
                                        $sonuc = $guncelle->execute(array(
                                            'isim' => $_POST['isim'],
                                            'soyisim' => $_POST['soyisim'],
                                            'telefon' => $_POST['telefon'],
                                            'eposta' => $_POST['eposta'],
                                            'uye_tip' => $_POST['tip'],
                                            'firma_unvan' => $_POST['firma_unvan'],
                                            'tc_no' => $_POST['tc'],
                                            'vergi_dairesi' => $_POST['vergi_dairesi'],
                                            'vergi_no' => $_POST['vergi_no'],
                                            'uyesifre' => $mdSifre,
                                            'uye_grup' => $_POST['uye_grup'],
                                            'onay' => $_POST['onay']
                                        ));
                                        if($sonuc){
                                            $_SESSION['main_alert'] = 'success';
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                        /*  <========SON=========>>> Şifre değiştiriliyor SON */
                                    }else{
                                        /* Eski Şifre */
                                        $guncelle = $db->prepare("UPDATE uyeler SET
                                       isim=:isim,     
                                       soyisim=:soyisim,
                                       telefon=:telefon,
                                       eposta=:eposta,
                                       uye_tip=:uye_tip,
                                       firma_unvan=:firma_unvan,
                                       tc_no=:tc_no,
                                       vergi_dairesi=:vergi_dairesi,
                                       vergi_no=:vergi_no,
                                       uye_grup=:uye_grup,
                                       onay=:onay
                                     WHERE id={$_POST['user_id']}      
                                    ");
                                        $sonuc = $guncelle->execute(array(
                                            'isim' => $_POST['isim'],
                                            'soyisim' => $_POST['soyisim'],
                                            'telefon' => $_POST['telefon'],
                                            'eposta' => $_POST['eposta'],
                                            'uye_tip' => $_POST['tip'],
                                            'firma_unvan' => $_POST['firma_unvan'],
                                            'tc_no' => $_POST['tc'],
                                            'vergi_dairesi' => $_POST['vergi_dairesi'],
                                            'vergi_no' => $_POST['vergi_no'],
                                            'uye_grup' => $_POST['uye_grup'],
                                            'onay' => $_POST['onay']
                                        ));
                                        if($sonuc){
                                            $_SESSION['main_alert'] = 'success';
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }
                                        /*  <========SON=========>>> Eski Şifre SON */
                                    }
                                }else{
                                    $_SESSION['main_alert'] = 'emailerror';
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                                }
                            }else{
                                $_SESSION['main_alert'] = 'emailhave';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                            }
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=user_detail&userID='.$_POST['user_id'].'');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /*  delete */
            if($_GET['status'] == 'user_delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {

                    $resimKontrol = $db->prepare("select * from uyeler where id=:id ");
                    $resimKontrol->execute(array(
                        'id' => $_GET['no'],
                    ));
                    if($resimKontrol->rowCount()>'0'  ) {
                        $resim = $resimKontrol->fetch(PDO::FETCH_ASSOC);
                    }

                    if($resimKontrol->rowCount()>'0'  ) {
                        $silmeislem = $db->prepare("DELETE from uyeler WHERE id=:id");
                        $silmeislemSuccess = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($silmeislemSuccess) {
                            /* Adresleri sil */
                            $s1 = $db->prepare("DELETE from uyeler_adres WHERE uye_id=:uye_id");
                            $s1->execute(array(
                                'uye_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> Adresleri sil SON */

                            /* sepet sil */
                            $s2 = $db->prepare("DELETE from sepet WHERE uye_id=:uye_id");
                            $s2->execute(array(
                                'uye_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> sepet sil SON */

                            /* sipariş sil */
                            $s3 = $db->prepare("DELETE from siparisler WHERE uye_id=:uye_id");
                            $s3->execute(array(
                                'uye_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> sipariş sil SON */

                            /* Destek ve cevaplar */
                            $s4 = $db->prepare("DELETE from destek_talebi WHERE uye_id=:uye_id");
                            $s4->execute(array(
                                'uye_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> Destek ve cevaplar SON */

                            /* Log */
                            $s4 = $db->prepare("DELETE from uyeler_log WHERE uye_id=:uye_id");
                            $s4->execute(array(
                                'uye_id' => $_GET['no']
                            ));
                            /*  <========SON=========>>> Log SON */
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  delete SON */



            /* SMS  */
            if($_GET['status'] == 'noti_sms' && isset($_GET['userID'])) {
                if ($_GET['userID'] == !null) {
                    if($sms['durum'] == '1' ) {
                        $user = $_GET['userID'];
                        $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                        $kullaniciCek->execute(array(
                            'id' => $user
                        ));
                        if($kullaniciCek->rowCount()>'0'  ) {
                            $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                            if($userRow['sms_durum'] == '1'  ) {
                                $_SESSION['main_alert'] = 'smsnotihave';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                            }else{
                                $numara = $userRow['telefon'];
                                $mesaj_icerik = ''.$diller['adminpanel-bildirim-text-2'].' '.$userRow['isim'].' '.$userRow['soyisim'].', '.$diller['adminpanel-bildirim-text-14'].' ';
                                include 'inc/modules/users/user_noti_sms.php';
                                $guncelle = $db->prepare("UPDATE uyeler SET
                                     sms_durum=:sms_durum   
                                 WHERE id={$_GET['userID']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'sms_durum' => '1'
                                ));
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'smsoff';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> SMS  SON */

            /* Email */
            if($_GET['status'] == 'noti_email' && isset($_GET['userID'])    ) {
                if ($_GET['userID'] == !null) {
                    if($ayar['smtp_durum'] == '1' ) {
                        $user = $_GET['userID'];
                        $kullaniciCek = $db->prepare("select * from uyeler where id=:id ");
                        $kullaniciCek->execute(array(
                            'id' => $user
                        ));
                        if($kullaniciCek->rowCount()>'0'  ) {
                            $userRow = $kullaniciCek->fetch(PDO::FETCH_ASSOC);
                            if($userRow['eposta_durum'] == '1' ) {
                                $_SESSION['main_alert'] = 'emailnotihave';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                            }else{
                                $eposta = $userRow['eposta'];
                                $isim = $userRow['isim'];
                                $soyisim = $userRow['soyisim'];
                                $guncelle = $db->prepare("UPDATE uyeler SET
                                     eposta_durum=:eposta_durum   
                                 WHERE id={$_GET['userID']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'eposta_durum' => '1'
                                ));
                                include 'inc/modules/users/user_noti_email.php';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        $_SESSION['main_alert'] = 'smtpoff';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=users');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Email SON */


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