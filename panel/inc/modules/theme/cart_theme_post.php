<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'main_update'){
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            /* Genel Güncelleme */
            if($_GET['status'] == 'main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE odeme_ayar SET
                            sepet_font=:sepet_font,
                            alisveris_arkaplan=:alisveris_arkaplan,
                            sepet_page_button_bg=:sepet_page_button_bg,
                            sepet_kdv_goster=:sepet_kdv_goster,
                            sepet_havale_goster=:sepet_havale_goster,
                            sepet_urunfiyat_uyari=:sepet_urunfiyat_uyari,
                            sepet_kupon_button=:sepet_kupon_button,
                            kargo_limit_sepet=:kargo_limit_sepet,
                            kargo_limit_sepet_button=:kargo_limit_sepet_button,
                            kargo_limit_sepet_button_size=:kargo_limit_sepet_button_size,
                            kargo_limit_sepet_sayac=:kargo_limit_sepet_sayac,
                            kargo_limit_sepet_sayac_button=:kargo_limit_sepet_sayac_button
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'sepet_font' => $_POST['sepet_font'],
                        'alisveris_arkaplan' => colorFormat($_POST['alisveris_arkaplan']),
                        'sepet_page_button_bg' => $_POST['sepet_page_button_bg'],
                        'sepet_kdv_goster' => $_POST['sepet_kdv_goster'],
                        'sepet_havale_goster' => $_POST['sepet_havale_goster'],
                        'sepet_urunfiyat_uyari' => $_POST['sepet_urunfiyat_uyari'],
                        'sepet_kupon_button' => $_POST['sepet_kupon_button'],
                        'kargo_limit_sepet' => $_POST['kargo_limit_sepet'],
                        'kargo_limit_sepet_button' => $_POST['kargo_limit_sepet_button'],
                        'kargo_limit_sepet_button_size' => $_POST['kargo_limit_sepet_button_size'],
                        'kargo_limit_sepet_sayac' => $_POST['kargo_limit_sepet_sayac'],
                        'kargo_limit_sepet_sayac_button' => $_POST['kargo_limit_sepet_sayac_button']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_cart');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Genel Güncelleme SON */

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