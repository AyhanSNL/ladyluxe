<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'add' || $_GET['status'] == 'update' || $_GET['status'] == 'delete' || $_GET['status'] == 'multidelete' || $_GET['status'] == 'theme_settings' ) {


            if($_GET['status'] == 'theme_settings'  ) {
                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_header_settings');
                $_SESSION['collepse_status'] = 'topHAcc';
            }


            /*  Insert */
            if($_GET['status'] == 'add'  ) {
                if($_POST && isset($_POST['insert'])  ) {

                    /* Link Türleri */
                    if($_POST['url_tur']==!null  ) {


                        /* url olmasın */
                        if($_POST['url_tur']=='0'  ) {
                            $url = null;
                            $url_tur = '0';
                        }
                        /*  <========SON=========>>> url olmasın SON */

                        /* Modül Linki Seçili */
                        if($_POST['url_tur']=='1'  ) {
                            $url = $_POST['modul_url'];
                            $url_tur = '1';
                        }
                        /*  <========SON=========>>> Modül Linki Seçili SON */

                        /* Manuel URL */
                        if($_POST['url_tur']=='2'  ) {
                            $url = $_POST['manuel_url'];
                            $url_tur = '2';
                        }
                        /*  <========SON=========>>> Manuel URL SON */



                    }else{
                        $url = null;
                        $url_tur = '0';
                    }
                    /*  <========SON=========>>> Link Türleri SON */

                    $kaydet = $db->prepare("INSERT INTO headertop_menu SET
                                    url_tur=:url_tur,
                                    url=:url,
                                    baslik=:baslik,
                                    dil=:dil,
                                  durum=:durum,
                                  mobil=:mobil,
                                  spot=:spot,
                                  ikon=:ikon,
                                  sira=:sira,
                                  yeni_sekme=:yeni_sekme,
                                  area=:area
                    ");
                    $sonuc = $kaydet->execute(array(
                        'url_tur' => $url_tur,
                        'url' => $url,
                        'baslik' => $_POST['baslik'],
                        'dil' => $_SESSION['dil'],
                        'durum' => '1',
                        'mobil' => $_POST['mobil'],
                        'spot' => $_POST['spot'],
                        'ikon' => $_POST['ikon'],
                        'sira' => $_POST['sira'],
                        'yeni_sekme' => $_POST['yeni_sekme'],
                        'area' => $_POST['area']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=topheader_links');
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


                    /* Link Türleri */
                    if($_POST['url_tur_edit']==!null  ) {


                        /* url olmasın */
                        if($_POST['url_tur_edit']=='0'  ) {
                            $url = null;
                            $url_tur = '0';
                        }
                        /*  <========SON=========>>> url olmasın SON */

                        /* Modül Linki Seçili */
                        if($_POST['url_tur_edit']=='1'  ) {
                            $url = $_POST['modul_url'];
                            $url_tur = '1';
                        }
                        /*  <========SON=========>>> Modül Linki Seçili SON */

                        /* Manuel URL */
                        if($_POST['url_tur_edit']=='2'  ) {
                            $url = $_POST['manuel_url'];
                            $url_tur = '2';
                        }
                        /*  <========SON=========>>> Manuel URL SON */



                    }else{
                        $url = null;
                        $url_tur = '0';
                    }
                    /*  <========SON=========>>> Link Türleri SON */

                    
                    
                    
                    $guncelle = $db->prepare("UPDATE headertop_menu SET
                                   url_tur=:url_tur,
                                    url=:url,
                                    baslik=:baslik,
                                    mobil=:mobil,
                                  durum=:durum,
                                  spot=:spot,
                                  ikon=:ikon,
                                  sira=:sira,
                                  yeni_sekme=:yeni_sekme,
                                  area=:area
                             WHERE id={$_POST['link_id']}
                            ");
                    $sonuc = $guncelle->execute(array(
                        'url_tur' => $url_tur,
                        'url' => $url,
                        'baslik' => $_POST['baslik'],
                        'mobil' => $_POST['mobil'],
                        'durum' => $_POST['durum'],
                        'spot' => $_POST['spot'],
                        'ikon' => $_POST['ikon'],
                        'sira' => $_POST['sira'],
                        'yeni_sekme' => $_POST['yeni_sekme'],
                        'area' => $_POST['area']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=topheader_links');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>>  Update SON */



            /* Delete */
            if($_GET['status'] == 'delete'  ) {
                if(isset($_GET['no']) && $_GET['no'] == !null ) {
                    $silmeislem = $db->prepare("DELETE from headertop_menu WHERE id=:id");
                    $deleteSuccs = $silmeislem->execute(array(
                       'id' => $_GET['no']
                    ));
                    if ($deleteSuccs) {
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=topheader_links');
                    }else {
                        echo 'veritabanı hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Delete SON */


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