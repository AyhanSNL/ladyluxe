<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'xml_export' || $_GET['status'] == 'xml_export_edit' || $_GET['status'] == 'xml_delete') {

            $tarih = date('Y-m-d');
            $saat = date('G:i:s');
            $key = rand(0,(int) 9999123999999);

            if($_GET['status'] == 'xml_delete'  ) {
                if ($_POST) {
                    if ($_POST['sil'] <= '0') {
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_export');
                    } else {
                        $liste = $_POST['sil'];
                        foreach ($liste as $idler) {
                            $silmeislem = $db->prepare("DELETE from urun_export WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $idler
                            ));
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_export');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'xml_export_edit'  ) {
                if ($_POST && isset($_POST['exportDo']) && $_POST['xml_id']) {
                    $baslik = $_POST['baslik'];
                    $dil = $_POST['dil'];
                    $parabirimi = $_POST['parabirimi'];
                    $kar = $_POST['kar'];
                    $limit_start = $_POST['limit_start'];
                    $limit_end = $_POST['limit_end'];
                    $ipler = $_POST['ipler'];
                    $katListesi = $_POST['kategoriler'];
                    if($katListesi == !null  ) {
                        foreach ($katListesi as $kat){
                            $kategoriler .= ''. $kat.',';
                        }
                    }else{
                        $kategoriler = null;
                    }
                    $format = $_POST['tur'];
                    $guncelle = $db->prepare("UPDATE urun_export SET
                            baslik=:baslik,
                            n11_sablon=:n11_sablon,
                            dil=:dil,
                            parabirimi=:parabirimi,
                            kar=:kar,
                            limit_start=:limit_start,
                            limit_end=:limit_end,
                            ipler=:ipler,
                            kategoriler=:kategoriler,
                            tarih=:tarih,
                            saat=:saat,
                            dosya_tur=:dosya_tur,
                            tur=:tur,
                            ok_id=:ok_id,
                            ok_baslik=:ok_baslik,
                            ok_gorsel=:ok_gorsel,
                            ok_stok=:ok_stok,
                            ok_stokkod=:ok_stokkod,
                            ok_barkod=:ok_barkod,
                            ok_fiyat=:ok_fiyat,
                            ok_alisfiyat=:ok_alisfiyat,
                            ok_kargodesi=:ok_kargodesi,
                            ok_kargotutar=:ok_kargotutar,
                            ok_parabirimi=:ok_parabirimi,
                            ok_kat=:ok_kat,
                            ok_marka=:ok_marka,
                            ok_aciklama=:ok_aciklama,
                            ok_ozelfiyat=:ok_ozelfiyat,
                            ok_eskifiyat=:ok_eskifiyat     
                     WHERE id={$_POST['xml_id']}      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'baslik' => $baslik,
                        'n11_sablon' => $_POST['n11_sablon'],
                        'dil' => $dil,
                        'parabirimi' => $parabirimi,
                        'kar' => $kar,
                        'limit_start' => $limit_start,
                        'limit_end' => $limit_end,
                        'ipler' => $ipler,
                        'kategoriler' => $kategoriler,
                        'tarih' => $tarih,
                        'saat' => $saat,
                        'dosya_tur' => 'xml',
                        'tur' => $format,
                        'ok_id' => $_POST['ok_id'],
                        'ok_baslik' => $_POST['ok_baslik'],
                        'ok_gorsel' => $_POST['ok_gorsel'],
                        'ok_stok' => $_POST['ok_stok'],
                        'ok_stokkod' => $_POST['ok_stokkod'],
                        'ok_barkod' => $_POST['ok_barkod'],
                        'ok_fiyat' => $_POST['ok_fiyat'],
                        'ok_alisfiyat' => $_POST['ok_alisfiyat'],
                        'ok_kargodesi' => $_POST['ok_kargodesi'],
                        'ok_kargotutar' => $_POST['ok_kargotutar'],
                        'ok_parabirimi' => $_POST['ok_parabirimi'],
                        'ok_kat' => $_POST['ok_kat'],
                        'ok_marka' => $_POST['ok_marka'],
                        'ok_aciklama' => $_POST['ok_aciklama'],
                        'ok_ozelfiyat' => $_POST['ok_ozelfiyat'],
                        'ok_eskifiyat' => $_POST['ok_eskifiyat']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_export');
                        $_SESSION['main_alert'] = 'success';
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }

            if($_GET['status'] == 'xml_export'  ) {
                if ($_POST && isset($_POST['exportDo'])) {
                    $baslik = $_POST['baslik'];
                    $dil = $_POST['dil'];
                    $parabirimi = $_POST['parabirimi'];
                    $kar = $_POST['kar'];
                    $limit_start = $_POST['limit_start'];
                    $limit_end = $_POST['limit_end'];
                    $ipler = $_POST['ipler'];
                    $katListesi = $_POST['kategoriler'];
                    if($katListesi == !null  ) {
                        foreach ($katListesi as $kat){
                            $kategoriler .= ''. $kat.',';
                        }
                    }else{
                        $kategoriler = null;
                    }
                    $format = $_POST['tur'];

                    $kaydet = $db->prepare("INSERT INTO urun_export SET
                            baslik=:baslik,
                            n11_sablon=:n11_sablon,
                            dil=:dil,
                            parabirimi=:parabirimi,
                            kar=:kar,
                            limit_start=:limit_start,
                            limit_end=:limit_end,
                            ipler=:ipler,
                            kategoriler=:kategoriler,
                            tarih=:tarih,
                            saat=:saat,
                            output_key=:output_key,
                            dosya_tur=:dosya_tur,
                            tur=:tur,
                            ok_id=:ok_id,
                            ok_baslik=:ok_baslik,
                            ok_gorsel=:ok_gorsel,
                            ok_stok=:ok_stok,
                            ok_stokkod=:ok_stokkod,
                            ok_barkod=:ok_barkod,
                            ok_fiyat=:ok_fiyat,
                            ok_alisfiyat=:ok_alisfiyat,
                            ok_kargodesi=:ok_kargodesi,
                            ok_kargotutar=:ok_kargotutar,
                            ok_parabirimi=:ok_parabirimi,
                            ok_kat=:ok_kat,
                            ok_marka=:ok_marka,
                            ok_aciklama=:ok_aciklama,
                            ok_ozelfiyat=:ok_ozelfiyat,
                            ok_eskifiyat=:ok_eskifiyat
                    ");
                    $sonuc = $kaydet->execute(array(
                        'baslik' => $baslik,
                        'n11_sablon' => $_POST['n11_sablon'],
                        'dil' => $dil,
                        'parabirimi' => $parabirimi,
                        'kar' => $kar,
                        'limit_start' => $limit_start,
                        'limit_end' => $limit_end,
                        'ipler' => $ipler,
                        'kategoriler' => $kategoriler,
                        'tarih' => $tarih,
                        'saat' => $saat,
                        'output_key' => $key,
                        'dosya_tur' => 'xml',
                        'tur' => $format,
                        'ok_id' => $_POST['ok_id'],
                        'ok_baslik' => $_POST['ok_baslik'],
                        'ok_gorsel' => $_POST['ok_gorsel'],
                        'ok_stok' => $_POST['ok_stok'],
                        'ok_stokkod' => $_POST['ok_stokkod'],
                        'ok_barkod' => $_POST['ok_barkod'],
                        'ok_fiyat' => $_POST['ok_fiyat'],
                        'ok_alisfiyat' => $_POST['ok_alisfiyat'],
                        'ok_kargodesi' => $_POST['ok_kargodesi'],
                        'ok_kargotutar' => $_POST['ok_kargotutar'],
                        'ok_parabirimi' => $_POST['ok_parabirimi'],
                        'ok_kat' => $_POST['ok_kat'],
                        'ok_marka' => $_POST['ok_marka'],
                        'ok_aciklama' => $_POST['ok_aciklama'],
                        'ok_ozelfiyat' => $_POST['ok_ozelfiyat'],
                        'ok_eskifiyat' => $_POST['ok_eskifiyat']
                    ));
                    if($sonuc){
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_export');
                        $_SESSION['main_alert'] = 'success';
                    }else{
                    echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }


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