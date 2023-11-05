<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'login_logs' || $_GET['status'] == 'user_logs' || $_GET['status'] == 'admin_logs' ) {


            /* Login Logs */
            if($_GET['status'] == 'login_logs'  ) {
                $silmeislem = $db->prepare("DELETE from login_log ");
                $delete = $silmeislem->execute();
                if ($delete) {
                    header('Location:'.$ayar['panel_url'].'pages.php?page=login_log');
                    $_SESSION['main_alert'] = 'success';
                }else {
                    echo 'veritabanı hatası';
                }
            }
            /*  <========SON=========>>> Login Logs SON */

            /* Admin Log */
            if($_GET['status'] == 'admin_logs' && isset($_GET['no'])  ) {
                $silmeislem = $db->prepare("DELETE from yonetici_log where admin_id=:admin_id ");
                $delete = $silmeislem->execute(array(
                    'admin_id' => $_GET['no']
                ));
                if ($delete) {

                    $admince = $db->prepare("select * from yonetici where id=:id ");
                    $admince->execute(array(
                        'id' => $_GET['no'],
                    ));
                    $admin = $admince->fetch(PDO::FETCH_ASSOC);


                    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_log&no='.$admin['random_id'].'');
                    $_SESSION['main_alert'] = 'success';
                }else {
                    echo 'veritabanı hatası';
                }
            }
            /*  <========SON=========>>> Admin Log SON */



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