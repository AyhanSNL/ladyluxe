<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' ||  $_GET['status'] == 'edit' ||  $_GET['status'] == 'delete' ||  $_GET['status'] == 'multidelete') {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }

            /*  Add */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {
                   if($_POST['baslik'] && $_POST['icerik']  ) {

                       if($_POST['seo_url'] == !null  ) {
                           $seo_url = seo($_POST['seo_url']);
                       }else{
                           $seo_url = seo($_POST['baslik']);
                       }

                       if($_POST['seo_baslik']==!null  ) {
                           $seo_title = $_POST['seo_baslik'];
                       }else{
                           $seo_title = $_POST['baslik'];
                       }

                       $sefLinkKontrol = $db->prepare("select * from htmlsayfa where seo_url=:seo_url ");
                       $sefLinkKontrol->execute(array(
                           'seo_url' => $seo_url
                       ));
                       if($sefLinkKontrol->rowCount()<='0'  ) {
                           $kaydet = $db->prepare("INSERT INTO htmlsayfa SET
                                baslik=:baslik,
                                icerik=:icerik,
                                durum=:durum,
                                dil=:dil,
                                seo_url=:seo_url,
                                tags=:tags,
                                meta_desc=:meta_desc,
                                nav_durum=:nav_durum,
                                sayfa_font=:sayfa_font,
                                arkaplan=:arkaplan,
                                seo_baslik=:seo_baslik
                        ");
                           $sonuc = $kaydet->execute(array(
                               'baslik' => $_POST['baslik'],
                               'icerik' => $_POST['icerik'],
                               'durum' => $_POST['durum'],
                               'dil' => $_SESSION['dil'],
                               'seo_url' => $seo_url,
                               'tags' => $_POST['tags'],
                               'meta_desc' => $_POST['meta_desc'],
                               'nav_durum' => $_POST['nav_durum'],
                               'sayfa_font' => $_POST['sayfa_font'],
                               'arkaplan' => colorFormat($_POST['arkaplan']),
                               'seo_baslik' => $seo_title
                           ));
                           if($sonuc){
                               $_SESSION['main_alert'] = 'success';
                               header('Location:'.$ayar['panel_url'].'pages.php?page=page_management');
                           }else{
                               echo 'Veritabanı Hatası';
                           }
                       }else{
                           $_SESSION['main_alert'] = 'seflink';
                           header('Location:'.$ayar['panel_url'].'pages.php?page=page_management');
                       }
                   }else{
                       $_SESSION['main_alert'] = 'zorunlu';
                       header('Location:'.$ayar['panel_url'].'pages.php?page=page_management');
                   }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Add SON */

            /*  Edit */
            if($_GET['status'] == 'edit'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['baslik'] && $_POST['icerik']  ) {
                        if($_POST['seo_url'] == !null  ) {
                            $seo_url = seo($_POST['seo_url']);
                        }else{
                            $seo_url = seo($_POST['baslik']);
                        }

                        if($_POST['seo_baslik']==!null  ) {
                            $seo_title = $_POST['seo_baslik'];
                        }else{
                            $seo_title = $_POST['baslik'];
                        }

                            $guncelle = $db->prepare("UPDATE htmlsayfa SET
                                baslik=:baslik,
                                icerik=:icerik,
                                durum=:durum,
                                seo_url=:seo_url,
                                tags=:tags,
                                meta_desc=:meta_desc,
                                nav_durum=:nav_durum,
                                sayfa_font=:sayfa_font,
                                arkaplan=:arkaplan,
                                seo_baslik=:seo_baslik
                         WHERE id={$_POST['page_id']}      
                        ");
                            $sonuc = $guncelle->execute(array(
                                'baslik' => $_POST['baslik'],
                                'icerik' => $_POST['icerik'],
                                'durum' => $_POST['durum'],
                                'seo_url' => $seo_url,
                                'tags' => $_POST['tags'],
                                'meta_desc' => $_POST['meta_desc'],
                                'nav_durum' => $_POST['nav_durum'],
                                'sayfa_font' => $_POST['sayfa_font'],
                                'arkaplan' => colorFormat($_POST['arkaplan']),
                                'seo_baslik' => $seo_title
                            ));
                            if($sonuc){
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=page_management');
                            }else{
                                echo 'Veritabanı Hatası';
                            }

                    }else{
                        $_SESSION['main_alert'] = 'zorunlu';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=page_management');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Edit SON */

            /*  Delete */
            if($_GET['status'] == 'delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {
                    $silmeislem = $db->prepare("DELETE from htmlsayfa WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                        'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=page_management');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Delete SON */

            /* Multi Delete */
            if($_GET['status'] == 'multidelete'  ) {
                if($_POST) {
                    $liste = $_POST['sil'];
                    foreach ($liste as $idler){
                        $sorgu = $db->prepare("select * from htmlsayfa where id='$idler' ");
                        $sorgu->execute();
                        if($sorgu->rowCount()>'0'  ) {
                            $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                            $silmeislem = $db->prepare("DELETE from htmlsayfa WHERE id=:id");
                            $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                    }
                    $_SESSION['main_alert'] ='success';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=page_management');
                }else{
                    $_SESSION['main_alert'] ='nocheck';
                    header('Location:'.$ayar['panel_url'].'pages.php?page=page_management');
                }
            }
            /*  <========SON=========>>> Multi Delete SON */


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