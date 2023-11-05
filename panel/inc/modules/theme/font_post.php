<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'font_add' || $_GET['status'] == 'font_edit' || $_GET['status'] == 'font_delete' ){

                /* Font Ekle */
            if($_GET['status'] == 'font_add'  ) {
                if($_POST && isset($_POST['add'])  ) {

                    $kaydet = $db->prepare("INSERT INTO fontlar SET
                     font_adi=:font_adi,      
                     kod=:kod,
                     sira=:sira,
                     durum=:durum
                   ");
                    $sonuc = $kaydet->execute(array(
                        'font_adi' => $_POST['font_adi'],
                        'kod' => $_POST['kod'],
                        'sira' => $_POST['sira'],
                        'durum' => $_POST['durum']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=fonts');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
                /*  <========SON=========>>> Font Ekle SON */


            /* Font Düzenle */
            if($_GET['status'] == 'font_edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE fontlar SET
                                            font_adi=:font_adi,      
                                             kod=:kod,
                                             sira=:sira,
                                             durum=:durum    
                         WHERE id={$_POST['font_id']}      
                        ");
                    $sonuc = $guncelle->execute(array(
                        'font_adi' => $_POST['font_adi'],
                        'kod' => $_POST['kod'],
                        'sira' => $_POST['sira'],
                        'durum' => $_POST['durum']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=fonts');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Font Düzenle SON */

            /* font sil */
            if($_GET['status'] == 'font_delete'  ) {
                $silmeislem = $db->prepare("DELETE from fontlar WHERE id=:id");
                $sil = $silmeislem->execute(array(
                   'id' => $_GET['no']
                ));
                if ($sil) {
                    $_SESSION['main_alert'] = 'success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=fonts');
                }else {
                    echo 'veritabanı hatası';
                }
            }
            /*  <========SON=========>>> font sil SON */


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