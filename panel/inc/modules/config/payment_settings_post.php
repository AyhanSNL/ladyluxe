<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {

            /* Payment update */
                if($_POST && isset($_POST['update'])  ) {

                    if($_POST['kapida_odeme_limit'] == !null  ) {
                     $kapida_limit = $_POST['kapida_odeme_limit'];
                    }else{
                        $kapida_limit = '0';
                    }
                    if($_POST['kapida_odeme_nakit_tutar'] == !null  ) {
                        $kapida_nakit = $_POST['kapida_odeme_nakit_tutar'];
                    }else{
                        $kapida_nakit = '0';
                    }
                    if($_POST['kapida_odeme_kart_tutar'] == !null  ) {
                        $kapida_kart = $_POST['kapida_odeme_kart_tutar'];
                    }else{
                        $kapida_kart = '0';
                    }

                    $guncelle = $db->prepare("UPDATE odeme_ayar SET
                            kredi_kart=:kredi_kart,
                            kredi_kart_doviz_durum=:kredi_kart_doviz_durum,
                            kredi_kart_siparis_durum=:kredi_kart_siparis_durum,
                            havale_eft=:havale_eft,
                            havale_siparis_banka_button=:havale_siparis_banka_button,
                            havale_odeme_bildirim=:havale_odeme_bildirim,
                            havale_eft_siparis_durum=:havale_eft_siparis_durum,
                            havale_doviz_durum=:havale_doviz_durum,
                            kapida_odeme_limit=:kapida_odeme_limit,
                            kapida_odeme_kart=:kapida_odeme_kart,
                            kapida_odeme_nakit=:kapida_odeme_nakit,
                            kapida_odeme_nakit_tutar=:kapida_odeme_nakit_tutar,
                            kapida_odeme_kart_tutar=:kapida_odeme_kart_tutar,
                            kapida_odeme_siparis_durum=:kapida_odeme_siparis_durum,
                            kapida_odeme_doviz_durum=:kapida_odeme_doviz_durum
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'kredi_kart' => $_POST['kredi_kart'],
                        'kredi_kart_doviz_durum' => $_POST['kredi_kart_doviz_durum'],
                        'kredi_kart_siparis_durum' => $_POST['kredi_kart_siparis_durum'],
                        'havale_eft' => $_POST['havale_eft'],
                        'havale_siparis_banka_button' => $_POST['havale_siparis_banka_button'],
                        'havale_odeme_bildirim' => $_POST['havale_odeme_bildirim'],
                        'havale_eft_siparis_durum' => $_POST['havale_eft_siparis_durum'],
                        'havale_doviz_durum' => $_POST['havale_doviz_durum'],
                        'kapida_odeme_limit' => $kapida_limit,
                        'kapida_odeme_kart' => $_POST['kapida_odeme_kart'],
                        'kapida_odeme_nakit' => $_POST['kapida_odeme_nakit'],
                        'kapida_odeme_nakit_tutar' => $kapida_nakit,
                        'kapida_odeme_kart_tutar' => $kapida_kart,
                        'kapida_odeme_siparis_durum' => $_POST['kapida_odeme_siparis_durum'],
                        'kapida_odeme_doviz_durum' => $_POST['kapida_odeme_doviz_durum']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=payment_settings');
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