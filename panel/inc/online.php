<?php
ob_start();
session_start();
error_reporting(0);
include "../../includes/config/config.php";
$settings=$db->prepare("SELECT * from ayarlar where id='1'");
$settings->execute(array(0));
$ayar=$settings->fetch(PDO::FETCH_ASSOC);
/* AdmIN Kontrol */
$adminSorgu = $db->prepare("select * from yonetici where user_adi=:user_adi ");
$adminSorgu->execute(array(
    'user_adi' => $_SESSION['admin_user_session']
));
$adminRow = $adminSorgu->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> AdmIN Kontrol SON */
/* Yetki çek */
$yetkiSorgu = $db->prepare("select * from yetki_grup where id=:id ");
$yetkiSorgu->execute(array(
    'id' => $adminRow['yetki']
));
$yetki = $yetkiSorgu->fetch(PDO::FETCH_ASSOC);
/*  <========SON=========>>> Yetki çek SON */
if ($yetki['ziyaretci_istatistik'] == '1') {

    function total_online()
    {
        global $db;
        $current_time = time();
        $timeout = $current_time - (80);

        $select_total = $db->prepare("SELECT * From ziyaretci_online WHERE time>='$timeout'");
        $select_total->execute();
        $total_online_visitors = $select_total->rowCount();

        return $total_online_visitors;
    }

    $total_online_visitors = total_online();
    ?>
    <div style="width: 100%; text-align: center; ">
        <?php if ($total_online_visitors > '0') { ?>
            <img src="assets/images/people.jpg" style="width: 65px">
        <?php } else { ?>
            <img src="assets/images/nopeople.png" style="width: 65px">
        <?php } ?>
        <h1><?php echo $total_online_visitors; ?></h1>
    </div>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>