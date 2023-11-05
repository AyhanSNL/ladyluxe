<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ( $_GET['status'] == 'update' || $_GET['status'] == 'delete'  ) {


            if($_GET['status'] == 'theme_settings'  ) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                $_SESSION['collepse_status'] = 'topHAcc';
            }



            /*  Update */
            if($_GET['status'] == 'update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['order_no'] && $_POST['transfer_no']  ) {
                        $siparis = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
                        $siparis->execute(array(
                            'siparis_no' => $_POST['order_no'],
                        ));
                        if($siparis->rowCount()>'0' ) {
                            $guncelle = $db->prepare("UPDATE odeme_bildirim SET
                                    durum=:durum
                             WHERE id={$_POST['transfer_no']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'durum' => $_POST['durum'],
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=bank_transfer');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else {
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Update SON */



            /* Delete */
            if($_GET['status'] == 'delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {
                    $silmeislem = $db->prepare("DELETE from odeme_bildirim WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=bank_transfer');
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