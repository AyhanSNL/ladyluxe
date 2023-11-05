<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'update' && $_POST && isset($_POST['update']) ) {
            $guncelle = $db->prepare("UPDATE cache SET
                    secenek_vitrin=:secenek_vitrin,
                    secenek_vitrin_zaman=:secenek_vitrin_zaman,
                    vitrin1=:vitrin1,
                    vitrin1_zaman=:vitrin1_zaman,
                    headermenu=:headermenu,
                    headermenu_zaman=:headermenu_zaman,
                    marka=:marka,
                    marka_zaman=:marka_zaman,
                    slider=:slider,
                    slider_zaman=:slider_zaman,
                    slider_orta_zaman=:slider_orta_zaman,
                    slider_orta=:slider_orta,
                    footer=:footer,
                    footer_zaman=:footer_zaman,
                    tkutu=:tkutu,
                    tkutu_zaman=:tkutu_zaman,
                    resimli_vitrin=:resimli_vitrin,
                    resimli_vitrin_zaman=:resimli_vitrin_zaman,
                    resimli_vitrin_2=:resimli_vitrin_2,
                    resimli_vitrin_2_zaman=:resimli_vitrin_2_zaman
             WHERE id='1'      
            ");
            $sonuc = $guncelle->execute(array(
                'secenek_vitrin' => $_POST['secenek_vitrin'],
                'secenek_vitrin_zaman' => $_POST['secenek_vitrin_zaman'],
                'vitrin1' => $_POST['vitrin1'],
                'vitrin1_zaman' => $_POST['vitrin1_zaman'],
                'headermenu' => $_POST['headermenu'],
                'headermenu_zaman' => $_POST['headermenu_zaman'],
                'marka' => $_POST['marka'],
                'marka_zaman' => $_POST['marka_zaman'],
                'slider' => $_POST['slider'],
                'slider_zaman' => $_POST['slider_zaman'],
                'slider_orta_zaman' => $_POST['slider_orta_zaman'],
                'slider_orta' => $_POST['slider_orta'],
                'footer' => $_POST['footer'],
                'footer_zaman' => $_POST['footer_zaman'],
                'tkutu' => $_POST['tkutu'],
                'tkutu_zaman' => $_POST['tkutu_zaman'],
                'resimli_vitrin' => $_POST['resimli_vitrin'],
                'resimli_vitrin_zaman' => $_POST['resimli_vitrin_zaman'],
                'resimli_vitrin_2' => $_POST['resimli_vitrin_2'],
                'resimli_vitrin_2_zaman' => $_POST['resimli_vitrin_2_zaman']
            ));
            if($sonuc){
                header('Location:'.$ayar['panel_url'].'pages.php?page=cache_settings');
                $_SESSION['main_alert'] = 'success';
            }else{
            echo 'Veritabanı Hatası';
            }
        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=cache_settings');
    $_SESSION['main_alert'] = 'demo';
}