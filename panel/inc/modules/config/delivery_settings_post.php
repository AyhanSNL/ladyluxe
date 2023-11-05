<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {

            /* Payment update */
                if($_POST && isset($_POST['update'])  ) {

                    if($_POST['kargo_sabit_ucret'] == !null  ) {
                     $kargo_sabit = $_POST['kargo_sabit_ucret'];
                    }else{
                        $kargo_sabit = '0';
                    }
                    if($_POST['kargo_limit'] == !null  ) {
                        $kargo_limit = $_POST['kargo_limit'];
                    }else{
                        $kargo_limit = '0';
                    }

                    $guncelle = $db->prepare("UPDATE odeme_ayar SET
                            kargo_sistemi=:kargo_sistemi,
                            kargo_sabit=:kargo_sabit,
                            kargo_sabit_ucret=:kargo_sabit_ucret,
                            kargo_limit=:kargo_limit,
                            kargo_limit_urundetay=:kargo_limit_urundetay
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'kargo_sistemi' => $_POST['kargo_sistemi'],
                        'kargo_sabit' => $_POST['kargo_sabit'],
                        'kargo_sabit_ucret' => $kargo_sabit,
                        'kargo_limit' => $kargo_limit,
                        'kargo_limit_urundetay' => $_POST['kargo_limit_urundetay']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=delivery_settings');
                    }else{
                    echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }

}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}