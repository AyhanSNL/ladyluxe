<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'update' || $_GET['status'] == 'delete'   ) {

            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }


            /*  Insert */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    $kaydet = $db->prepare("INSERT INTO headertop_html SET
                                    arkaplan=:arkaplan,  
                                    dil=:dil,   
                                    mobil=:mobil,
                                  durum=:durum,
                                  text_color=:text_color,
                                  a_color=:a_color,
                                  a_hover_color=:a_hover_color,
                                  padding=:padding,
                                  icerik=:icerik      
                    ");
                    $sonuc = $kaydet->execute(array(
                        'arkaplan' => colorFormat($_POST['arkaplan']),
                        'dil' => $_SESSION['dil'],
                        'mobil' => $_POST['mobil'],
                        'durum' => $_POST['durum'],
                        'text_color' => colorFormat($_POST['text_color']),
                        'a_color' => colorFormat($_POST['a_color']),
                        'a_hover_color' => colorFormat($_POST['a_hover_color']),
                        'padding' => $_POST['padding'],
                        'icerik' => $_POST['icerik']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=tophtml_area');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Insert SON */



            /*  Update */
            if($_GET['status'] == 'update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    $guncelle = $db->prepare("UPDATE headertop_html SET
                                  arkaplan=:arkaplan,     
                                  durum=:durum,
                                   mobil=:mobil,
                                  text_color=:text_color,
                                  a_color=:a_color,
                                  a_hover_color=:a_hover_color,
                                  padding=:padding,
                                  icerik=:icerik
                             WHERE id={$_POST['update_id']}      
                            ");
                    $sonuc = $guncelle->execute(array(
                        'arkaplan' => colorFormat($_POST['arkaplan']),
                        'durum' => $_POST['durum'],
                        'mobil' => $_POST['mobil'],
                        'text_color' => colorFormat($_POST['text_color']),
                        'a_color' => colorFormat($_POST['a_color']),
                        'a_hover_color' => colorFormat($_POST['a_hover_color']),
                        'padding' => $_POST['padding'],
                        'icerik' => $_POST['icerik']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=tophtml_area');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Update SON */


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