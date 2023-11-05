<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {

    if($_POST && isset($_POST['settingsUpdate'])  ) {
        $siteurl = $_POST['site_url'];
        $panel_url = $_POST['panel_url'];
        $baslik = $_POST['site_baslik'];
        $site_desc = $_POST['site_desc'];
        $site_tags = $_POST['site_tags'];
        $site_width = $_POST['site_width'];
        $site_bg = $_POST['site_bg_color'];
        $sekme = $_POST['sekme_degistir_yazi'];
        $lazy = $_POST['lazy'];
        $site_captcha = $_POST['site_captcha'];
        $totop = $_POST['totop'];
        $totop_bg = $_POST['totop_bg'];
        $totop_icon = $_POST['totop_icon'];
        $totop_bottom = $_POST['totop_bottom'];
        $totop_radius = $_POST['totop_radius'];
        
        /* Renk Replace */
        $site_bg  = $_POST['site_bg_color'];
        $eski   = '#';
        $yeni   = '';
        $site_bg = str_replace($eski, $yeni, $site_bg);

        $totop_bg  = $_POST['totop_bg'];
        $eski   = '#';
        $yeni   = '';
        $totop_bg = str_replace($eski, $yeni, $totop_bg);

        $totop_icon  = $_POST['totop_icon'];
        $eski   = '#';
        $yeni   = '';
        $totop_icon = str_replace($eski, $yeni, $totop_icon);
        /*  <========SON=========>>> Renk Replace SON */



        if($siteurl && $panel_url  && $totop_bottom && $baslik && ($site_width == '1' || $site_width == '0')){
            $guncelle = $db->prepare("UPDATE ayarlar SET
                    site_baslik=:site_baslik,
                    panel_url=:panel_url,
                    site_url=:site_url,
                    protokol=:protokol,
                    demo_mod=:demo_mod,
                    site_desc=:site_desc,
                    site_tags=:site_tags,
                    site_width=:site_width,
                    site_bg_color=:site_bg_color,
                    sekme_degistir_yazi=:sekme_degistir_yazi,
                    site_captcha=:site_captcha,
                    lazy=:lazy,
                    uye_log=:uye_log,
                    yonetici_log=:yonetici_log,
                    login_log=:login_log,
                    totop=:totop,
                    totop_bg=:totop_bg,
                    totop_icon=:totop_icon,
                    totop_bottom=:totop_bottom,
                    totop_radius=:totop_radius
             WHERE id='1'      
            ");
            $sonuc = $guncelle->execute(array(
                'site_baslik' => $baslik,
                'panel_url' => $panel_url,
                'site_url' => $siteurl,
                'protokol' => $_POST['protokol'],
                'demo_mod' => $_POST['demo_mod'],
                'site_desc' => $site_desc,
                'site_tags' => $site_tags,
                'site_width' => $site_width,
                'site_bg_color' => $site_bg,
                'sekme_degistir_yazi' => $sekme,
                'site_captcha' => $site_captcha,
                'lazy' => $lazy,
                'uye_log' => $_POST['uye_log'],
                'yonetici_log' => $_POST['yonetici_log'],
                'login_log' => $_POST['login_log'],
                'totop' => $totop,
                'totop_bg' => $totop_bg,
                'totop_icon' => $totop_icon,
                'totop_bottom' => $totop_bottom,
                'totop_radius' => $totop_radius
            ));
            if($sonuc){
                header('Location:'.$ayar['panel_url'].'pages.php?page=settings');
                $_SESSION['main_alert'] = 'success';
            }else{
            echo 'Veritabanı Hatası';
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=settings');
            $_SESSION['main_alert'] = 'zorunlu';
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }

}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=settings');
    $_SESSION['main_alert'] = 'demo';
}
?>