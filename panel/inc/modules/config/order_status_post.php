<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'edit' || $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete'  ) {


            /* Status Insert */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    $kaydet = $db->prepare("INSERT INTO siparis_durumlar SET
                      baslik=:baslik,      
                      renk=:renk,
                      durum=:durum,
                      sira=:sira,
                      bstrp_bg=:bstrp_bg,
                      ikon=:ikon
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $_POST['baslik'],
                        'renk' => $_POST['renk'],
                        'durum' => '1',
                        'sira' => '0',
                        'bstrp_bg' => $_POST['bstrp_bg'],
                        'ikon' => $_POST['ikon']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_status');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Status Insert SON */



            /* Status Update */
            if($_GET['status'] == 'edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE siparis_durumlar SET
                      baslik=:baslik,      
                      renk=:renk,
                      durum=:durum,
                      sira=:sira,
                      bstrp_bg=:bstrp_bg,
                      ikon=:ikon
                     WHERE id={$_POST['status_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $_POST['baslik'],
                        'renk' => $_POST['renk'],
                        'durum' => $_POST['durum'],
                        'sira' => $_POST['sira'],
                        'bstrp_bg' => $_POST['bstrp_bg'],
                        'ikon' => $_POST['ikon']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=order_status');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Status Update SON */


            /* Delete */
            if($_GET['status'] == 'delete' && isset($_GET['no'])  ) {
                if($_GET['no'] == !null  ) {
                 $silmeislem = $db->prepare("DELETE from siparis_durumlar WHERE id=:id");
                 $silmeislemSuccess = $silmeislem->execute(array(
                    'id' => $_GET['no']
                 ));
                 if ($silmeislemSuccess) {
                     $_SESSION['main_alert'] = 'success';
                     header('Location:'.$ayar['panel_url'].'pages.php?page=order_status');
                 }else {
                     echo 'veritabanı hatası';
                 }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Delete SON */

            /* Multi Delete */
            if($_GET['status'] == 'multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from siparis_durumlar where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                            $silmeislem = $db->prepare("DELETE from siparis_durumlar WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=order_status');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=order_status');
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