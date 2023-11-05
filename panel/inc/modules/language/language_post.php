<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'lang_add' || $_GET['status'] == 'lang_delete' || $_GET['status'] == 'lang_edit' ) {


            /* Add */
            if($_GET['status']=='lang_add'  ) {
                if($_POST && isset($_POST['langAdd'])  ) {

                    $baslik = $_POST['baslik'];
                    $sira = $_POST['sira'];
                    $kod = $_POST['dil_kodu'];
                    $var = $_POST['varsayilan'];
                    $durum = $_POST['durum'];
                    $area = $_POST['area'];

                    if($baslik && $sira && $kod ) {
                        /* Varsayılan kontrolü */
                        if($var == '1'  ) {
                            $guncelle = $db->prepare("UPDATE dil SET
                                           varsayilan=:varsayilan 
                                    ");
                            $sonuc = $guncelle->execute(array(
                                'varsayilan' => '0'
                            ));
                            unset($_SESSION['dil']);
                        }
                        /*  <========SON=========>>> Varsayılan kontrolü SON */

                        $kaydet = $db->prepare("INSERT INTO dil SET
                                baslik=:baslik,
                                sira=:sira,
                                kisa_ad=:kisa_ad,
                                varsayilan=:varsayilan,
                                durum=:durum,
                                flag=:flag,
                                area=:area
                        ");
                        $sonuc = $kaydet->execute(array(
                            'baslik' => $baslik,
                            'sira' => $sira,
                            'kisa_ad' => $kod,
                            'varsayilan' => $var,
                            'durum' => $durum,
                            'flag' => $kod,
                            'area' => $area
                        ));
                        if($sonuc){

                            include 'inc/modules/language/lang-home.php';
                            $uploads_dir = '/../../../../includes/lang/';
                            $dosya = $_POST["dil_kodu"];
                            $uzanti = ".php";

                            $dosya = fopen(__DIR__ . "$uploads_dir$_POST[dil_kodu]$uzanti", "a");
                            $yaz = fwrite($dosya, $home_content);


                            include 'inc/modules/language/lang-panel.php';
                            $uploads_dir = '/../../../../includes/lang/';
                            $dosya = $_POST["dil_kodu"];
                            $uzanti = "-panel.php";

                            $dosya = fopen(__DIR__ . "$uploads_dir$_POST[dil_kodu]$uzanti", "a");
                            $yaz = fwrite($dosya, $panel_content);
                            /*  <========SON=========>>> Dil Dosyası oluştur SON */

                            $_SESSION['main_alert'] ='success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=languages');
                            
                            /* Dil Dosyası oluştur */


                            
                            
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=languages');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Add SON */


            /* Delete */
            if($_GET['status']=='lang_delete') {
                if($_GET['no'] == !null && isset($_GET['no'])  ) {

                    $dilcek = $db->prepare("select * from dil where id=:id ");
                    $dilcek->execute(array(
                        'id' => $_GET['no'],
                    ));
                    $dil = $dilcek->fetch(PDO::FETCH_ASSOC);

                    if($dilcek->rowCount()>'0'  ) {
                        unlink("../includes/lang/$dil[kisa_ad].php");
                        unlink("../includes/lang/$dil[kisa_ad]-panel.php");
                        $silmeislem = $db->prepare("DELETE from dil WHERE id=:id");
                        $sil = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if ($sil) {
                            $_SESSION['main_alert'] ='success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=languages');
                        }else {
                            echo 'veritabanı hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=languages');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Delete SON */


            /* edit */
            if($_GET['status']=='lang_edit'  ) {
                if($_POST && isset($_POST['langEdit'])  ) {

                    $baslik = $_POST['baslik'];
                    $sira = $_POST['sira'];
                    $durum = $_POST['durum'];
                    $area = $_POST['area'];

                    if($baslik && $sira ) {


                        $guncelle = $db->prepare("UPDATE dil SET
                                baslik=:baslik,
                                sira=:sira,
                                durum=:durum,
                                area=:area
                         WHERE id={$_POST['lang_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $baslik,
                            'sira' => $sira,
                            'durum' => $durum,
                            'area' => $area
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] ='success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=languages');
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] ='zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=languages');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> edit SON */


        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'');
    $_SESSION['main_alert'] = 'demo';
}