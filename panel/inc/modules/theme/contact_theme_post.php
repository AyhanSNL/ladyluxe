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
                    $guncelle = $db->prepare("UPDATE ayarlar SET
                            iletisim_sayfa_font=:iletisim_sayfa_font,
                            iletisim_sayfa_bg=:iletisim_sayfa_bg,
                            iletisim_sayfa_maps=:iletisim_sayfa_maps,
                            iletisim_sayfa_nav=:iletisim_sayfa_nav,
                            iletisim_sayfa_tags=:iletisim_sayfa_tags,
                            iletisim_sayfa_form=:iletisim_sayfa_form,
                            iletisim_sayfa_desc=:iletisim_sayfa_desc
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'iletisim_sayfa_font' => $_POST['iletisim_sayfa_font'],
                        'iletisim_sayfa_bg' => colorFormat($_POST['iletisim_sayfa_bg']),
                        'iletisim_sayfa_maps' => $_POST['iletisim_sayfa_maps'],
                        'iletisim_sayfa_nav' => $_POST['iletisim_sayfa_nav'],
                        'iletisim_sayfa_tags' => $_POST['iletisim_sayfa_tags'],
                        'iletisim_sayfa_form' => $_POST['iletisim_sayfa_form'],
                        'iletisim_sayfa_desc' => $_POST['iletisim_sayfa_desc']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_contact');
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