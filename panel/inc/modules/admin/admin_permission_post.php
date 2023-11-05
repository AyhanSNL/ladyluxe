<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'per_edit' || $_GET['status'] == 'per_delete' || $_GET['status'] == 'per_add' ) {


         /* Delete */
            if($_GET['status']=='per_delete'  ) {
                $sorgu = $db->prepare("select * from yetki_grup where id=:id ");
                $sorgu->execute(array(
                    'id' => $_GET['no']
                ));
                if($sorgu->rowCount()>'0') {
                 $silmeislem = $db->prepare("DELETE from yetki_grup WHERE id=:id");
                 $sil = $silmeislem->execute(array(
                    'id' => $_GET['no']
                 ));
                 if ($sil) {
                     header('Location:'.$ayar['panel_url'].'pages.php?page=admin_permission');
                     $_SESSION['main_alert'] = 'success';
                 }else {
                     echo 'veritabanı hatası';
                 }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
         /*  <========SON=========>>> Delete SON */

            /* Insert */
            if($_GET['status']=='per_add'  ) {
                if($_POST && isset($_POST['perAdd'])  ) {
                    $baslik = $_POST['baslik'];
                    $sira = $_POST['sira'];
                    if($baslik && $sira  ) {
                        $kaydet = $db->prepare("INSERT INTO yetki_grup SET
                             baslik=:baslik,
                             sira=:sira,
                             parasut=:parasut,
                             demo=:demo,
                             kisayol_ekle=:kisayol_ekle,   
                             site_ayarlar=:site_ayarlar,
                             ayar_yonet=:ayar_yonet,
                             yonetici=:yonetici,
                             dil_yonet=:dil_yonet,
                             ayar_diger=:ayar_diger,
                             bell=:bell,
                             katalog=:katalog,
                             urun=:urun,
                             kat=:kat,
                             marka=:marka,
                             varyant=:varyant,
                             toplu=:toplu,
                             urun_yorum=:urun_yorum,
                             siparis=:siparis,
                             siparis_yonet=:siparis_yonet,
                             odeme_bildirim=:odeme_bildirim,
                             siparis_diger=:siparis_diger,
                             uyelik=:uyelik,
                             uye_yonet=:uye_yonet,
                             ticket=:ticket,
                             uyelik_ayar=:uyelik_ayar,
                             gelenkutusu=:gelenkutusu,
                             kampanya=:kampanya,
                             indirimkod=:indirimkod,
                             eposta_yonet=:eposta_yonet,
                             sms_yonet=:sms_yonet, 
                             bildirim_gonder=:bildirim_gonder,
                             modul=:modul,
                             modul_header_footer=:modul_header_footer,
                             sirala=:sirala,
                             modul_diger=:modul_diger,
                             modul_vitrin=:modul_vitrin,
                             icerik_yonetim=:icerik_yonetim,
                             sayfa_yonet=:sayfa_yonet,
                             blog_hizmet=:blog_hizmet,
                             galeri=:galeri,
                             ptable=:ptable,
                             icerik_diger=:icerik_diger,
                             entegrasyon=:entegrasyon,
                             entegrasyon_urun=:entegrasyon_urun,
                             entegrasyon_sms=:entegrasyon_sms,
                             entegrasyon_eposta=:entegrasyon_eposta,
                             entegrasyon_map=:entegrasyon_map,
                             entegrasyon_pazar=:entegrasyon_pazar,
                             yapilandirma=:yapilandirma,
                             tema_ayarlar=:tema_ayarlar,
                             ziyaretci_istatistik=:ziyaretci_istatistik,
                             veriler=:veriler
                        ");
                        $sonuc = $kaydet->execute(array(
                            'baslik' => $_POST['baslik'],
                            'sira' => $_POST['sira'],
                            'parasut' => $_POST['parasut'],
                            'demo' => $_POST['demo'],
                            'kisayol_ekle' => $_POST['kisayol_ekle'],
                            'site_ayarlar' => $_POST['site_ayarlar'],
                            'ayar_yonet' => $_POST['ayar_yonet'],
                            'yonetici' => $_POST['yonetici'],
                            'dil_yonet' => $_POST['dil_yonet'],
                            'ayar_diger' => $_POST['ayar_diger'],
                            'bell' => $_POST['bell'],
                            'katalog' => $_POST['katalog'],
                            'urun' => $_POST['urun'],
                            'kat' => $_POST['kat'],
                            'marka' => $_POST['marka'],
                            'varyant' => $_POST['varyant'],
                            'toplu' => $_POST['toplu'],
                            'urun_yorum' => $_POST['urun_yorum'],
                            'siparis' => $_POST['siparis'],
                            'siparis_yonet' => $_POST['siparis_yonet'],
                            'odeme_bildirim' => $_POST['odeme_bildirim'],
                            'siparis_diger' => $_POST['siparis_diger'],
                            'uyelik' => $_POST['uyelik'],
                            'uye_yonet' => $_POST['uye_yonet'],
                            'ticket' => $_POST['ticket'],
                            'uyelik_ayar' => $_POST['uyelik_ayar'],
                            'gelenkutusu' => $_POST['gelenkutusu'],
                            'kampanya' => $_POST['kampanya'],
                            'indirimkod' => $_POST['indirimkod'],
                            'eposta_yonet' => $_POST['eposta_yonet'],
                            'sms_yonet' => $_POST['sms_yonet'],
                            'bildirim_gonder' => $_POST['bildirim_gonder'],
                            'modul' => $_POST['modul'],
                            'modul_header_footer' => $_POST['modul_header_footer'],
                            'sirala' => $_POST['sirala'],
                            'modul_diger' => $_POST['modul_diger'],
                            'modul_vitrin' => $_POST['modul_vitrin'],
                            'icerik_yonetim' => $_POST['icerik_yonetim'],
                            'sayfa_yonet' => $_POST['sayfa_yonet'],
                            'blog_hizmet' => $_POST['blog_hizmet'],
                            'galeri' => $_POST['galeri'],
                            'ptable' => $_POST['ptable'],
                            'icerik_diger' => $_POST['icerik_diger'],
                            'entegrasyon' => $_POST['entegrasyon'],
                            'entegrasyon_urun' => $_POST['entegrasyon_urun'],
                            'entegrasyon_sms' => $_POST['entegrasyon_sms'],
                            'entegrasyon_eposta' => $_POST['entegrasyon_eposta'],
                            'entegrasyon_map' => $_POST['entegrasyon_map'],
                            'entegrasyon_pazar' => $_POST['entegrasyon_pazar'],
                            'yapilandirma' => $_POST['yapilandirma'],
                            'tema_ayarlar' => $_POST['tema_ayarlar'],
                            'ziyaretci_istatistik' => $_POST['ziyaretci_istatistik'],
                            'veriler' => $_POST['veriler']
                        ));
                        if($sonuc){
                            header('Location:'.$ayar['panel_url'].'pages.php?page=admin_permission');
                            $_SESSION['main_alert'] = 'success';
                        }else{
                        echo 'Veritabanı Hatası';
                        }
                    }else{
                        header('Location:'.$ayar['panel_url'].'pages.php?page=admin_permission');
                        $_SESSION['main_alert'] = 'zorunlu';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Insert SON */

            /* Update */
            if($_GET['status']=='per_edit'  ) {
                if ($_POST && isset($_POST['perEdit'])) {
                   $guncelle = $db->prepare("UPDATE yetki_grup SET
                             baslik=:baslik,
                             sira=:sira,
                             parasut=:parasut,
                             demo=:demo,
                             kisayol_ekle=:kisayol_ekle,   
                             site_ayarlar=:site_ayarlar,
                             ayar_yonet=:ayar_yonet,
                             yonetici=:yonetici,
                             dil_yonet=:dil_yonet,
                             ayar_diger=:ayar_diger,
                             bell=:bell,
                             katalog=:katalog,
                             urun=:urun,
                             kat=:kat,
                             marka=:marka,
                             varyant=:varyant,
                             toplu=:toplu,
                             urun_yorum=:urun_yorum,
                             siparis=:siparis,
                             siparis_yonet=:siparis_yonet,
                             odeme_bildirim=:odeme_bildirim,
                             siparis_diger=:siparis_diger,
                             uyelik=:uyelik,
                             uye_yonet=:uye_yonet,
                             ticket=:ticket,
                             uyelik_ayar=:uyelik_ayar,
                             gelenkutusu=:gelenkutusu,
                             kampanya=:kampanya,
                             indirimkod=:indirimkod,
                             eposta_yonet=:eposta_yonet,
                             sms_yonet=:sms_yonet, 
                             bildirim_gonder=:bildirim_gonder,
                             modul=:modul,
                             modul_header_footer=:modul_header_footer,
                             sirala=:sirala,
                             modul_diger=:modul_diger,
                             modul_vitrin=:modul_vitrin,
                             icerik_yonetim=:icerik_yonetim,
                             sayfa_yonet=:sayfa_yonet,
                             blog_hizmet=:blog_hizmet,
                             galeri=:galeri,
                             ptable=:ptable,
                             icerik_diger=:icerik_diger,
                             entegrasyon=:entegrasyon,
                             entegrasyon_urun=:entegrasyon_urun,
                             entegrasyon_sms=:entegrasyon_sms,
                             entegrasyon_eposta=:entegrasyon_eposta,
                             entegrasyon_map=:entegrasyon_map,
                             entegrasyon_pazar=:entegrasyon_pazar,
                             yapilandirma=:yapilandirma,
                             tema_ayarlar=:tema_ayarlar,
                             ziyaretci_istatistik=:ziyaretci_istatistik,
                             veriler=:veriler
                    WHERE id={$_POST['per_id']}      
                   ");
                   $sonuc = $guncelle->execute(array(
                       'baslik' => $_POST['baslik'],
                       'sira' => $_POST['sira'],
                       'parasut' => $_POST['parasut'],
                       'demo' => $_POST['demo'],
                       'kisayol_ekle' => $_POST['kisayol_ekle'],
                       'site_ayarlar' => $_POST['site_ayarlar'],
                       'ayar_yonet' => $_POST['ayar_yonet'],
                       'yonetici' => $_POST['yonetici'],
                       'dil_yonet' => $_POST['dil_yonet'],
                       'ayar_diger' => $_POST['ayar_diger'],
                       'bell' => $_POST['bell'],
                       'katalog' => $_POST['katalog'],
                       'urun' => $_POST['urun'],
                       'kat' => $_POST['kat'],
                       'marka' => $_POST['marka'],
                       'varyant' => $_POST['varyant'],
                       'toplu' => $_POST['toplu'],
                       'urun_yorum' => $_POST['urun_yorum'],
                       'siparis' => $_POST['siparis'],
                       'siparis_yonet' => $_POST['siparis_yonet'],
                       'odeme_bildirim' => $_POST['odeme_bildirim'],
                       'siparis_diger' => $_POST['siparis_diger'],
                       'uyelik' => $_POST['uyelik'],
                       'uye_yonet' => $_POST['uye_yonet'],
                       'ticket' => $_POST['ticket'],
                       'uyelik_ayar' => $_POST['uyelik_ayar'],
                       'gelenkutusu' => $_POST['gelenkutusu'],
                       'kampanya' => $_POST['kampanya'],
                       'indirimkod' => $_POST['indirimkod'],
                       'eposta_yonet' => $_POST['eposta_yonet'],
                       'sms_yonet' => $_POST['sms_yonet'],
                       'bildirim_gonder' => $_POST['bildirim_gonder'],
                       'modul' => $_POST['modul'],
                       'modul_header_footer' => $_POST['modul_header_footer'],
                       'sirala' => $_POST['sirala'],
                       'modul_diger' => $_POST['modul_diger'],
                       'modul_vitrin' => $_POST['modul_vitrin'],
                       'icerik_yonetim' => $_POST['icerik_yonetim'],
                       'sayfa_yonet' => $_POST['sayfa_yonet'],
                       'blog_hizmet' => $_POST['blog_hizmet'],
                       'galeri' => $_POST['galeri'],
                       'ptable' => $_POST['ptable'],
                       'icerik_diger' => $_POST['icerik_diger'],
                       'entegrasyon' => $_POST['entegrasyon'],
                       'entegrasyon_urun' => $_POST['entegrasyon_urun'],
                       'entegrasyon_sms' => $_POST['entegrasyon_sms'],
                       'entegrasyon_eposta' => $_POST['entegrasyon_eposta'],
                       'entegrasyon_map' => $_POST['entegrasyon_map'],
                       'entegrasyon_pazar' => $_POST['entegrasyon_pazar'],
                       'yapilandirma' => $_POST['yapilandirma'],
                       'tema_ayarlar' => $_POST['tema_ayarlar'],
                       'ziyaretci_istatistik' => $_POST['ziyaretci_istatistik'],
                       'veriler' => $_POST['veriler']
                   ));
                   if($sonuc){
                       header('Location:'.$ayar['panel_url'].'pages.php?page=permission_edit&no='.$_POST['per_id'].'');
                       $_SESSION['main_alert'] = 'success';
                   }else{
                   echo 'Veritabanı Hatası';
                   }
                }
            }
            /*  <========SON=========>>> Update SON */


        }else{
            header('Location:'.$ayar['site_url'].'404');
        }
    }else{
        header('Location:'.$ayar['site_url'].'404');
    }
}else{
    header('Location:'.$ayar['panel_url'].'pages.php?page=admin_permission');
    $_SESSION['main_alert'] = 'demo';
}