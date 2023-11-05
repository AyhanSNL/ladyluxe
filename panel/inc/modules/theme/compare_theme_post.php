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
                    $guncelle = $db->prepare("UPDATE compare_ayar SET
                            sayfa_font=:sayfa_font,
                            sayfa_bg=:sayfa_bg,
                            fiyat=:fiyat,
                            marka=:marka,
                            indirim=:indirim,
                            kargo=:kargo,
                            hizli=:hizli,
                            stok=:stok,
                            taksit=:taksit,
                            puan=:puan,
                            yeni=:yeni,
                            firsat=:firsat,
                            editor=:editor
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'sayfa_font' => $_POST['sayfa_font'],
                        'sayfa_bg' => colorFormat($_POST['sayfa_bg']),
                        'fiyat' => $_POST['fiyat'],
                        'marka' => $_POST['marka'],
                        'indirim' => $_POST['indirim'],
                        'kargo' => $_POST['kargo'],
                        'hizli' => $_POST['hizli'],
                        'stok' => $_POST['stok'],
                        'taksit' => $_POST['taksit'],
                        'puan' => $_POST['puan'],
                        'yeni' => $_POST['yeni'],
                        'firsat' => $_POST['firsat'],
                        'editor' => $_POST['editor']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_compare');
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