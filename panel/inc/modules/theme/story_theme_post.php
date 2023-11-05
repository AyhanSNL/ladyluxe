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
                    $guncelle = $db->prepare("UPDATE story_ayar SET
                            arkaplan=:arkaplan,
                            margin=:margin,
                            padding=:padding,
                            border_color=:border_color,
                            font_select=:font_select,
                            renk=:renk,
                            scroll_bg=:scroll_bg,
                            tur=:tur,
                            story_target=:story_target,
                            story_border=:story_border,
                            scroll_pasif=:scroll_pasif
                     WHERE id='1'     
                    ");
                    $sonuc = $guncelle->execute(array(
                        'arkaplan' => colorFormat($_POST['arkaplan']),
                        'margin' => $_POST['margin'],
                        'padding' => $_POST['padding'],
                        'border_color' => colorFormat($_POST['border_color']),
                        'font_select' => $_POST['font_select'],
                        'renk' => colorFormat($_POST['renk']),
                        'scroll_bg' => colorFormat($_POST['scroll_bg']),
                        'tur' => $_POST['tur'],
                        'story_target' => $_POST['story_target'],
                        'story_border' => colorFormat($_POST['story_border']),
                        'scroll_pasif' => colorFormat($_POST['scroll_pasif'])
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_story');
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