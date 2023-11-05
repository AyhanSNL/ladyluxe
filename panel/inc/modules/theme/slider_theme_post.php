<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if($_GET['status'] == 'top_slider' || $_GET['status'] == 'middle_slider'){
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            /* Genel Güncelleme */
            if($_GET['status'] == 'top_slider'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE slider_ayar SET
                            height=:height,
                            round=:round,
                            dots_renk=:dots_renk,
                            arkaplan=:arkaplan,
                            mobil_height=:mobil_height,
                            baslik_font=:baslik_font,
                            spot_font=:spot_font,
                            baslik_size=:baslik_size,
                            spot_size=:spot_size,
                            baslik_weight=:baslik_weight,
                            spot_weight=:spot_weight,
                            slider_width=:slider_width,
                            margin=:margin
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'height' => $_POST['height'],
                        'round' => $_POST['round'],
                        'dots_renk' => colorFormat($_POST['dots_renk']),
                        'arkaplan' => colorFormat($_POST['arkaplan']),
                        'mobil_height' => $_POST['mobil_height'],
                        'baslik_font' => $_POST['baslik_font'],
                        'spot_font' => $_POST['spot_font'],
                        'baslik_size' => $_POST['baslik_size'],
                        'spot_size' => $_POST['spot_size'],
                        'baslik_weight' => $_POST['baslik_weight'],
                        'spot_weight' => $_POST['spot_weight'],
                        'slider_width' => $_POST['slider_width'],
                        'margin' => $_POST['margin']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['collepse_status'] ='genelAcc';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_slider');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Genel Güncelleme SON */


            /* Middle Slider */
            if($_GET['status'] == 'middle_slider'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE slider2_ayar SET
                            height=:height,
                            arkaplan=:arkaplan,
                            mobil_height=:mobil_height,
                            border_color=:border_color,
                            padding=:padding,
                            radius=:radius,
                            margin=:margin
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'height' => $_POST['height'],
                        'arkaplan' => colorFormat($_POST['arkaplan']),
                        'mobil_height' => $_POST['mobil_height'],
                        'border_color' => colorFormat($_POST['border_color']),
                        'padding' => $_POST['padding'],
                        'radius' => $_POST['radius'],
                        'margin' => $_POST['margin']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['collepse_status'] ='otherAcc';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_slider');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Middle Slider SON */

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