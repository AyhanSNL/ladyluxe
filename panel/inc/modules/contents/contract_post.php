<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'user_contract_add' || $_GET['status'] == 'cookie_add' || $_GET['status'] == 'cookie_update' || $_GET['status'] == 'sale_contract_add' || $_GET['status'] == 'sale_contract_update' ||$_GET['status'] == 'user_contract_update' ) {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            /* Çerez Add */
            if($_GET['status'] == 'cookie_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['button_text'] && $_POST['spot']  ) {
                        $kaydet = $db->prepare("INSERT INTO cerez_ayar SET
                             dil=:dil,  
                             font=:font,
                             durum=:durum,
                               area=:area,
                             border=:border,
                             link=:link,
                             link_text=:link_text,
                             spot=:spot,
                             button_text=:button_text,
                             button_bg=:button_bg,
                             button_text_color=:button_text_color,
                             bg_color=:bg_color,
                             bg_text_color=:bg_text_color
                       ");
                        $sonuc = $kaydet->execute(array(
                            'dil' => $_SESSION['dil'],
                            'font' => $_POST['font'],
                            'durum' => $_POST['durum'],
                            'area' => $_POST['area'],
                            'border' => colorFormat($_POST['border']),
                            'link' => $_POST['link'],
                            'link_text' => $_POST['link_text'],
                            'spot' => $_POST['spot'],
                            'button_text' => $_POST['button_text'],
                            'button_bg' => colorFormat($_POST['button_bg']),
                            'button_text_color' => colorFormat($_POST['button_text_color']),
                            'bg_color' => colorFormat($_POST['bg_color']),
                            'bg_text_color' => colorFormat($_POST['bg_text_color'])
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=cookie_contract');
                        }else{
                            echo 'Veritabanı Hatası';
                        }

                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=cookie_contract');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Çerez Add SON */

            /* Çerez Edit */
            if($_GET['status'] == 'cookie_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['button_text'] && $_POST['spot'] && $_POST['page_id']  ) {
                        $guncelle = $db->prepare("UPDATE cerez_ayar SET
                             durum=:durum,
                             font=:font,
                             area=:area,
                             border=:border,
                             link=:link,
                             link_text=:link_text,
                             spot=:spot,
                             button_text=:button_text,
                             button_bg=:button_bg,
                             button_text_color=:button_text_color,
                             bg_color=:bg_color,
                             bg_text_color=:bg_text_color
                             WHERE id={$_POST['page_id']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'durum' => $_POST['durum'],
                            'font' => $_POST['font'],
                            'area' => $_POST['area'],
                            'border' => colorFormat($_POST['border']),
                            'link' => $_POST['link'],
                            'link_text' => $_POST['link_text'],
                            'spot' => $_POST['spot'],
                            'button_text' => $_POST['button_text'],
                            'button_bg' => colorFormat($_POST['button_bg']),
                            'button_text_color' => colorFormat($_POST['button_text_color']),
                            'bg_color' => colorFormat($_POST['bg_color']),
                            'bg_text_color' => colorFormat($_POST['bg_text_color'])
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=cookie_contract');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=cookie_contract');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Çerez Edit SON */



            /* Satış add */
            if($_GET['status'] == 'sale_contract_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                    if($_POST['baslik'] && $_POST['icerik']  ) {

                        $kaydet = $db->prepare("INSERT INTO htmlsayfa_sozlesmeler SET
                             dil=:dil,  
                             baslik=:baslik,
                             icerik=:icerik,
                             tur=:tur
                       ");
                        $sonuc = $kaydet->execute(array(
                            'dil' => $_SESSION['dil'],
                            'baslik' => $_POST['baslik'],
                            'icerik' => $_POST['icerik'],
                            'tur' => '1',
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=sale_contract');
                        }else{
                            echo 'Veritabanı Hatası';
                        }

                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sale_contract');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Satış add SON */

            /* Satış Edit */
            if($_GET['status'] == 'sale_contract_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['icerik'] && $_POST['page_id']  ) {
                        $guncelle = $db->prepare("UPDATE htmlsayfa_sozlesmeler SET
                             baslik=:baslik,
                             icerik=:icerik
                             WHERE id={$_POST['page_id']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'icerik' => $_POST['icerik']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=sale_contract');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=sale_contract');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Satış Edit SON */


            /*  Kullanıcı sözleşmesi Add */
            if($_GET['status'] == 'user_contract_add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                   if($_POST['baslik'] && $_POST['icerik']  ) {

                       $kaydet = $db->prepare("INSERT INTO htmlsayfa_sozlesmeler SET
                             dil=:dil,  
                             baslik=:baslik,
                             icerik=:icerik,
                             tur=:tur
                       ");
                       $sonuc = $kaydet->execute(array(
                           'dil' => $_SESSION['dil'],
                           'baslik' => $_POST['baslik'],
                           'icerik' => $_POST['icerik'],
                           'tur' => '2',
                       ));
                       if($sonuc){
                           $_SESSION['main_alert'] = 'success';
                           header('Location:'.$ayar['panel_url'].'pages.php?page=user_contract');
                       }else{
                       echo 'Veritabanı Hatası';
                       }
                       
                   }else{
                       $_SESSION['main_alert'] = 'zorunlu';
                       header('Location:'.$ayar['panel_url'].'pages.php?page=user_contract');
                   }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Kullanıcı sözleşmesi Add SON */

            /*  Edit */
            if($_GET['status'] == 'user_contract_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['icerik'] && $_POST['page_id']  ) {
                        $guncelle = $db->prepare("UPDATE htmlsayfa_sozlesmeler SET
                             baslik=:baslik,
                             icerik=:icerik
                             WHERE id={$_POST['page_id']}      
                            ");
                        $sonuc = $guncelle->execute(array(
                            'baslik' => $_POST['baslik'],
                            'icerik' => $_POST['icerik']
                        ));
                        if($sonuc){
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=user_contract');
                        }else{
                            echo 'Veritabanı Hatası';
                        }
                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=user_contract');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */



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