<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {

            /* Payment update */
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE odeme_ayar SET
                            pos_tur=:pos_tur,
                            paytr_id=:paytr_id,
                            paytr_key=:paytr_key,
                            paytr_salt=:paytr_salt,
                            taksit_max_paytr=:taksit_max_paytr,
                            paytr_tasarim=:paytr_tasarim,
                            paytr_test=:paytr_test,
                            shopier_user=:shopier_user,
                            shopier_pass=:shopier_pass,
                            iyzico_key=:iyzico_key,
                            iyzico_secure=:iyzico_secure,
                            iyzico_taksit_sayi=:iyzico_taksit_sayi,
                            iyzico_test=:iyzico_test
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'pos_tur' => $_POST['pos_tur'],
                        'paytr_id' => $_POST['paytr_id'],
                        'paytr_key' => $_POST['paytr_key'],
                        'paytr_salt' => $_POST['paytr_salt'],
                        'taksit_max_paytr' => $_POST['taksit_max_paytr'],
                        'paytr_tasarim' => $_POST['paytr_tasarim'],
                        'paytr_test' => $_POST['paytr_test'],
                        'shopier_user' => $_POST['shopier_user'],
                        'shopier_pass' => $_POST['shopier_pass'],
                        'iyzico_key' => $_POST['iyzico_key'],
                        'iyzico_secure' => $_POST['iyzico_secure'],
                        'iyzico_taksit_sayi' => $_POST['iyzico_taksit_sayi'],
                        'iyzico_test' => $_POST['iyzico_test']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=pos_settings');
                    }else{
                    echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            /*  <========SON=========>>> Payment update SON */

}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}