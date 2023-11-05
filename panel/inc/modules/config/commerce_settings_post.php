<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {

    /* Payment update */
    if($_POST && isset($_POST['update'])  ) {

        $guncelle = $db->prepare("UPDATE odeme_ayar SET
                            sepet_sistemi=:sepet_sistemi,
                            fiyat_gosterim_uyari=:fiyat_gosterim_uyari,
                            uyesiz_alisveris=:uyesiz_alisveris,
                            sepet_href=:sepet_href,
                            wp_no=:wp_no,
                            wp_siparis=:wp_siparis,
                            siparis_iptal=:siparis_iptal,
                            siparis_urun_iade=:siparis_urun_iade,
                            urun_stok_dus=:urun_stok_dus,
                            urun_stok_sinir=:urun_stok_sinir,
                            normalsiparis_durum=:normalsiparis_durum,
                            ucretsiz_alisveris=:ucretsiz_alisveris,
                            ucretsiz_alisveris_durum=:ucretsiz_alisveris_durum,
                            urun_karsilastirma=:urun_karsilastirma,
                            faturasiz_teslimat=:faturasiz_teslimat,
                            faturasiz_tc_zorunlu=:faturasiz_tc_zorunlu,
                            sepet_kupon=:sepet_kupon,
                            teslimat_sehir=:teslimat_sehir
                     WHERE id='1'     
                    ");
        $sonuc = $guncelle->execute(array(
            'sepet_sistemi' => $_POST['sepet_sistemi'],
            'fiyat_gosterim_uyari' => $_POST['fiyat_gosterim_uyari'],
            'uyesiz_alisveris' => $_POST['uyesiz_alisveris'],
            'sepet_href' => $_POST['sepet_href'],
            'wp_no' => $_POST['wp_no'],
            'wp_siparis' => $_POST['wp_siparis'],
            'siparis_iptal' => $_POST['siparis_iptal'],
            'siparis_urun_iade' => $_POST['siparis_urun_iade'],
            'urun_stok_dus' => $_POST['urun_stok_dus'],
            'urun_stok_sinir' => $_POST['urun_stok_sinir'],
            'normalsiparis_durum' => $_POST['normalsiparis_durum'],
            'ucretsiz_alisveris' => $_POST['ucretsiz_alisveris'],
            'ucretsiz_alisveris_durum' => $_POST['ucretsiz_alisveris_durum'],
            'urun_karsilastirma' => $_POST['urun_karsilastirma'],
            'faturasiz_teslimat' => $_POST['faturasiz_teslimat'],
            'faturasiz_tc_zorunlu' => $_POST['faturasiz_tc_zorunlu'],
            'sepet_kupon' => $_POST['sepet_kupon'],
            'teslimat_sehir' => $_POST['teslimat_sehir']
        ));
        if($sonuc){
            $_SESSION['main_alert'] = 'success';
            header('Location:'.$ayar['panel_url'].'pages.php?page=commerce_settings');
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