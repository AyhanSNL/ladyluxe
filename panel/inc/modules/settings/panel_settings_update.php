<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {

    if($_POST && isset($_POST['panelUpdate'])  ) {

        $baslik = $_POST['baslik'];
        $footer_text = $_POST['footer_text'];
        $footer_bg = $_POST['footer_bg'];
        $footer_text_color = $_POST['footer_text_color'];
        $fixed_header = $_POST['fixed_header'];
        $header_cache = $_POST['header_cache'];
        $panel_bildirim = $_POST['panel_bildirim'];
        $header_order = $_POST['header_order'];
        $header_iptal = $_POST['header_iptal'];
        $header_iade = $_POST['header_iade'];
        $header_ticket = $_POST['header_ticket'];
        $header_comment = $_POST['header_comment'];
        $header_inbox = $_POST['header_inbox'];
        $headermenu_overlay_op = $_POST['headermenu_overlay_op'];
        $shortlink = $_POST['shortlink'];
        $dash_alert= $_POST['dash_alert'];
        $dash_ust = $_POST['dash_ust'];
        $dash_istatistik = $_POST['dash_istatistik'];
        $dash_siparis = $_POST['dash_siparis'];
        $dash_alt = $_POST['dash_alt'];
        $bekleyen_isler_modal = $_POST['bekleyen_isler_modal'];

        /* Renk Replace */
        $footer_bg  = $_POST['footer_bg'];
        $eski   = '#';
        $yeni   = '';
        $footer_bg = str_replace($eski, $yeni, $footer_bg);

        $footer_text_color  = $_POST['footer_text_color'];
        $eski   = '#';
        $yeni   = '';
        $footer_text_color = str_replace($eski, $yeni, $footer_text_color);
        /*  <========SON=========>>> Renk Replace SON */



        if($baslik && $headermenu_overlay_op  ){
            $guncelle = $db->prepare("UPDATE panel_ayar SET
                    baslik=:baslik,
                    panel_nav=:panel_nav,
                    footer_text=:footer_text,
                    footer_bg=:footer_bg,
                    footer_text_color=:footer_text_color,
                    fixed_header=:fixed_header,
                    header_cache=:header_cache,
                    panel_bildirim=:panel_bildirim,
                    header_order=:header_order,
                    header_iptal=:header_iptal,
                    header_iade=:header_iade,
                    header_ticket=:header_ticket,
                    header_comment=:header_comment,
                    header_inbox=:header_inbox,
                    headermenu_overlay_op=:headermenu_overlay_op,
                    shortlink=:shortlink,
                    dash_alert=:dash_alert,
                    dash_ust=:dash_ust,
                    dash_istatistik=:dash_istatistik,
                    dash_siparis=:dash_siparis,
                    dash_alt=:dash_alt,
                    editor_dil=:editor_dil,
                    bekleyen_isler_modal=:bekleyen_isler_modal
             WHERE id='1'      
            ");
            $sonuc = $guncelle->execute(array(
                'baslik' => $baslik,
                'panel_nav' => $_POST['panel_nav'],
                'footer_text' => $footer_text,
                'footer_bg' => $footer_bg,
                'footer_text_color' => $footer_text_color,
                'fixed_header' => $fixed_header,
                'header_cache' => $header_cache,
                'panel_bildirim' => $panel_bildirim,
                'header_order' => $header_order,
                'header_iptal' => $header_iptal,
                'header_iade' => $header_iade,
                'header_ticket' => $header_ticket,
                'header_comment' => $header_comment,
                'header_inbox' => $header_inbox,
                'headermenu_overlay_op' => $headermenu_overlay_op,
                'shortlink' => $shortlink,
                'dash_alert' => $dash_alert,
                'dash_ust' => $dash_ust,
                'dash_istatistik' => $dash_istatistik,
                'dash_siparis' => $dash_siparis,
                'dash_alt' => $dash_alt,
                'editor_dil' => $_POST['editor_dil'],
                'bekleyen_isler_modal' => $bekleyen_isler_modal
            ));
            if($sonuc){
                header('Location:'.$ayar['panel_url'].'pages.php?page=panel_settings');
                $_SESSION['main_alert'] = 'success';
            }else{
            echo 'Veritabanı Hatası';
            }
        }else{
            header('Location:'.$ayar['panel_url'].'pages.php?page=panel_settings');
            $_SESSION['main_alert'] = 'zorunlu';
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }

}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=panel_settings');
    $_SESSION['main_alert'] = 'demo';
}
?>