<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
use Verot\Upload\Upload;

error_reporting(E_ALL);
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'import') {
            if($_GET['status'] == 'import'  ) {
                if ($_POST && isset($_POST['sync']) && $_POST['xml_id'] && $_POST['anatag'] && $_POST['idtag'] && $_POST['dosya'] && $_POST['basliktag'] && $_POST['stoktag'] && $_POST['fiyattag']) {
                    $dosya = $_POST['dosya'];
                    $anatag = $_POST['anatag'];
                    $idtag = $_POST['idtag'];
                    $basliktag = $_POST['basliktag'];
                    $stoktag = $_POST['stoktag'];
                    $fiyattag = $_POST['fiyattag'];
                    $gorseltag = $_POST['gorseltag'];
                    $kattag = $_POST['kattag'];
                    $markatag = $_POST['markatag'];
                    $barkodtag = $_POST['barkodtag'];
                    $stokkodtag = $_POST['stokkodtag'];
                    $aciklamatag = $_POST['aciklamatag'];
                    $xml_file = simplexml_load_file('inc/input/product/'.$dosya.'');
                    if($xml_file) {
                        function get_random_string($length = 7, $characters = "ABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789")
                        {
                            $return = "";
                            $num_characters = strlen($characters) - 1;
                            while (strlen($return) < $length) {
                                $return .= $characters[mt_rand(0, $num_characters)];
                            }
                            return $return;
                        }
                        /*  Tarihler */
                        $timestamp = date('Y-m-d G:i:s');
                        $sadetarih = date('Y-m-d');

                        /* Ekleyen */
                        $adminadi = $adminRow['user_adi'];
                        foreach ($xml_file->$anatag as $key){
                            $UrunKontrol = $db->prepare("select * from urun where xml_id=:xml_id and xml_product_id=:xml_product_id ");
                            $UrunKontrol->execute(array(
                                'xml_id' => $_POST['xml_id'],
                                'xml_product_id' => $key->$idtag
                            ));
                            if($UrunKontrol->rowCount()<='0' ) {
                                /* Yeni Ekle */


                                $urunKutuAyar = $db->prepare("select resim_w,resim_h,resim_big_w,resim_big_h from urun_kutu where id='1' ");
                                $urunKutuAyar->execute();
                                $urunboxRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
                                $resim_w = $urunboxRow['resim_w'];
                                $resim_h = $urunboxRow['resim_h'];
                                $resim_big_w = $urunboxRow['resim_big_w'];
                                $resim_big_h = $urunboxRow['resim_big_h'];

                                /* Ürün Fotoğrafı */
                                if($key->$gorseltag  ) {
                                    $imgURL = $key->$gorseltag;
                                    $resim  =$imgURL;
                                    $img_name = '_img_';
                                    $imgFolderAndName = '../images/temp/'.$img_name.'.jpg';
                                    $ch = curl_init($imgURL);
                                    $fp = fopen($imgFolderAndName, 'wb');
                                    curl_setopt($ch, CURLOPT_FILE, $fp);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_exec($ch);
                                    curl_close($ch);
                                    fclose($fp);
                                    include_once('inc/class.upload.php');
                                    $upload = new Upload($imgFolderAndName);
                                    if ($upload->uploaded) {
                                        $random = rand(0, (int)99991234569);
                                        $random2 = rand(0, (int)999);
                                        $upload->file_name_body_pre = 'product_';
                                        $upload->file_name_body_add = ''.$random.''.$random2.'';
                                        $upload->image_resize = true;
                                        $upload->image_ratio_crop = true;
                                        $upload->png_quality = 90;
                                        $upload->webp_quality = 92;
                                        $upload->jpeg_quality = 92;
                                        $upload->png_compression = 9;
                                        $upload->image_x = $resim_big_w;
                                        $upload->image_y = $resim_big_h;
                                        $upload->process("../images/product/big_photo");

                                        $upload->file_name_body_pre = 'product_';
                                        $upload->file_name_body_add = ''.$random.''.$random2.'';
                                        $upload->image_resize = true;
                                        $upload->image_ratio_crop = true;
                                        $upload->png_quality = 90;
                                        $upload->webp_quality = 92;
                                        $upload->jpeg_quality = 92;
                                        $upload->png_compression = 9;
                                        $upload->image_x = $resim_w;
                                        $upload->image_y = $resim_h;
                                        $upload->process("../images/product");
                                    }
                                    if ($upload->processed){
                                        $gorsel = $upload->file_dst_name;
                                        unlink(''.$imgFolderAndName.'');
                                    }
                                }else{
                                    $gorsel = 'no-img.jpg';
                                }



                                /* ürün Durumları */
                                if($_POST['pasif'] == '1'  ) {
                                    $durums = '0';
                                }else{
                                    $durums = '1';
                                }

                                /* Stok Kodu Ayarı */
                                $kodOlustur = get_random_string();
                                if(isset($key->$stokkodtag)  ) {
                                    $stokKoduAyar = $key->$stokkodtag;
                                }else{
                                    if($_POST['stokkod_ayar'] == '1'  ) {
                                        $stokKoduAyar= $kodOlustur;
                                    }else{
                                        $stokKoduAyar = '0';
                                    }
                                }
                                /* Marka */
                                if(isset($key->$markatag)) {
                                    $markaAdi = $key->$markatag;
                                    $markaSorgu = $db->prepare("select * from urun_marka where baslik like '$markaAdi'");
                                    $markaSorgu->execute();
                                    if($markaSorgu->rowCount()>'0'  ) {
                                        $markaRow = $markaSorgu->fetch(PDO::FETCH_ASSOC);
                                        $markaxml = $markaRow['id'];
                                    }else{
                                        if($_POST['marka_ayar'] == '1'  ) {
                                            $kaydet = $db->prepare("INSERT INTO urun_marka SET
                                                   baslik=:baslik,
                                                   baslik_seo=:baslik_seo,
                                                   seo_url=:seo_url,
                                                   durum=:durum,
                                                   sira=:sira,
                                                   anasayfa=:anasayfa
                                           ");
                                            $sonuc = $kaydet->execute(array(
                                                'baslik' => $markaAdi,
                                                'baslik_seo' => $markaAdi,
                                                'seo_url' => seo($markaAdi),
                                                'durum' => '1',
                                                'sira' => '1',
                                                'anasayfa' => '0'
                                            ));
                                            if($sonuc){
                                                $sonMarka = $db->prepare("select id from urun_marka order by id desc limit 1");
                                                $sonMarka->execute();
                                                $sonmarkaRow = $sonMarka->fetch(PDO::FETCH_ASSOC);
                                                $markaxml = $sonmarkaRow['id'];
                                            }else{
                                                $markaxml = '0';
                                            }
                                        }else{
                                            $markaxml = '0';
                                        }
                                    }
                                }else{
                                    $markaxml = '0';
                                }
                                /* Fiyat */
                                $fiyatNe = $key->$fiyattag;
                                if($_POST['ek_oran'] >'0'  ) {
                                    $ekOran = $_POST['ek_oran'];
                                    $fiyataEkle = kdvhesapla($fiyatNe,$ekOran);
                                    $fiyatxml = $fiyatNe+$fiyataEkle;
                                }else{
                                    $fiyatxml = $fiyatNe;
                                }
                                /* Kategori */
                                if(isset($key->$kattag)  ) {
                                    $kategoriAdi = $key->$kattag;
                                    $kategoriSorgu = $db->prepare("select * from urun_cat where baslik like '$kategoriAdi'");
                                    $kategoriSorgu->execute();
                                    if($kategoriSorgu->rowCount()>'0'  ) {
                                        $katRow = $kategoriSorgu->fetch(PDO::FETCH_ASSOC);
                                        $kategorixml = $katRow['id'];
                                    }else{
                                        if($_POST['kat_ayar'] == '1'  ) {
                                            $kaydet = $db->prepare("INSERT INTO urun_cat SET
                                                   baslik=:baslik,
                                                   baslik_seo=:baslik_seo,
                                                   seo_url=:seo_url,
                                                   dil=:dil,
                                                   ust_id=:ust_id,
                                                   durum=:durum,
                                                   sira=:sira,
                                                   fiyat_filtre=:fiyat_filtre
                                           ");
                                            $sonuc = $kaydet->execute(array(
                                                'baslik' => $kategoriAdi,
                                                'baslik_seo' => $kategoriAdi,
                                                'seo_url' => seo($kategoriAdi),
                                                'dil' => $_SESSION['dil'],
                                                'ust_id' => '0',
                                                'durum' => '1',
                                                'sira' => '1',
                                                'fiyat_filtre' => '1',
                                            ));
                                            if($sonuc){
                                                $sonKategori = $db->prepare("select id from urun_cat order by id desc limit 1");
                                                $sonKategori->execute();
                                                $sonkatRow = $sonKategori->fetch(PDO::FETCH_ASSOC);
                                                $kategorixml = $sonkatRow['id'];
                                            }else{
                                                $kategorixml = '0';
                                            }
                                        }else{
                                            $kategorixml = '0';
                                        }
                                    }
                                }else{
                                    $kategorixml = '0';
                                }
                                /* KDV Oranı */
                                if($_POST['kdv_oran'] >'0'  ) {
                                    $kdvOran = $_POST['kdv_oran'];
                                }else{
                                    $kdvOran = '18';
                                }
                                /*  <========SON=========>>> KDV Oranı SON */

                                /* Kargo Ücreti */
                                if($_POST['kargo'] == '1'  ) {
                                 $kargoUcret = $_POST['kargo_ucret'];
                                }else{
                                    $kargoUcret = '0';
                                }
                                /*  <========SON=========>>> Kargo Ücreti SON */


                                if($key->$stoktag > '0'  ) {
                                 $stokSayisi = $key->$stoktag;
                                }else{
                                    $stokSayisi = '0';
                                }

                                $kaydet = $db->prepare("INSERT INTO urun SET
                                    xml_id=:xml_id,
                                    xml_product_id=:xml_product_id,
                                    baslik=:baslik,
                                    seo_url=:seo_url,
                                    seo_baslik=:seo_baslik,
                                    siparis_islem=:siparis_islem,
                                    icerik=:icerik,
                                    gorsel=:gorsel,
                                    barkod=:barkod,
                                    iliskili_kat=:iliskili_kat,
                                    marka=:marka,
                                    stok=:stok,
                                    urun_kod=:urun_kod,
                                    fiyat=:fiyat,
                                    gorunmez=:gorunmez,
                                    durum=:durum,
                                    dil=:dil,
                                    taksit=:taksit,
                                    kat_id=:kat_id,
                                    yorum_durum=:yorum_durum,
                                    fiyat_goster=:fiyat_goster,
                                    kdv=:kdv,
                                    kdv_oran=:kdv_oran,
                                    kargo=:kargo,
                                    kargo_tipi=:kargo_tipi,
                                    tarih=:tarih,
                                    sade_tarih=:sade_tarih,
                                    ekleyen=:ekleyen,
                                    eski_fiyat=:eski_fiyat,
                                             alis_fiyat=:alis_fiyat,
                                             fiyat_tip2=:fiyat_tip2,
                                             havale_indirim_tutar=:havale_indirim_tutar,
                                             kargo_ucret=:kargo_ucret
                                    ");
                                $sonuc = $kaydet->execute(array(
                                    'xml_id' => $_POST['xml_id'],
                                    'xml_product_id' => $key->$idtag,
                                    'baslik' => $key->$basliktag,
                                    'seo_url' => seo($key->$basliktag),
                                    'seo_baslik' => $key->$basliktag,
                                    'siparis_islem' => '0',
                                    'icerik' => $key->$aciklamatag,
                                    'gorsel' => $gorsel,
                                    'barkod' => $key->$barkodtag,
                                    'iliskili_kat' => $kategorixml,
                                    'marka' => $markaxml,
                                    'stok' => $stokSayisi,
                                    'urun_kod' => $stokKoduAyar,
                                    'fiyat' => $fiyatxml,
                                    'gorunmez' => $_POST['gorunmez'],
                                    'durum' => $durums,
                                    'dil' => $_SESSION['dil'],
                                    'taksit' => $_POST['taksit_ayar'],
                                    'kat_id' => ''.$kategorixml.',',
                                    'yorum_durum' => $_POST['yorum_ayar'],
                                    'fiyat_goster' => $_POST['fiyat_goster'],
                                    'kdv' => $_POST['kdv'],
                                    'kdv_oran' => $kdvOran,
                                    'kargo' => $_POST['kargo'],
                                    'kargo_tipi' => '0',
                                    'tarih' => $timestamp,
                                    'sade_tarih' => $sadetarih,
                                    'ekleyen' => $adminadi,
                                    'eski_fiyat' => '0',
                                    'alis_fiyat' => '0',
                                    'fiyat_tip2' => '0',
                                    'havale_indirim_tutar' => '0',
                                    'kargo_ucret' => $kargoUcret
                                ));
                                /* XML Güncelle - Aktarıldı yap */
                                $guncelle = $db->prepare("UPDATE urun_import SET
                                                durum=:durum
                                         WHERE id={$_POST['xml_id']}      
                                        ");
                                $guncelle->execute(array(
                                    'durum' => '1'
                                ));

                                /*  <========SON=========>>> XML Güncelle - Aktarıldı yap SON */
                                /*  <========SON=========>>> Yeni Ekle SON */
                            }else{
                                $urun = $UrunKontrol->fetch(PDO::FETCH_ASSOC);
                                /* Güncelle */
                                if($_POST['upd_baslik'] || $_POST['upd_foto'] || $_POST['upd_stok'] || $_POST['upd_stokkod'] || $_POST['upd_aciklama'] || $_POST['upd_ek_oran'] || $_POST['upd_fiyat']) {
                                    /* Başlık */
                                    if($_POST['upd_baslik'] == '1'  ) {
                                        $updBaslik = $key->$basliktag;
                                        $updSeo = seo($key->$basliktag);
                                        $updSeoTitle = $key->$basliktag;
                                    }else{
                                        $updBaslik = $urun['baslik'];
                                        $updSeo = $urun['seo_url'];
                                        $updSeoTitle = $urun['seo_baslik'];
                                    }
                                    /*  <========SON=========>>> Başlık SON */

                                    /* İçerik */
                                    if($_POST['upd_aciklama'] == '1'  ) {
                                        $updAciklama = $key->$aciklamatag;
                                    }else{
                                        $updAciklama = $urun['icerik'];
                                    }
                                    /*  <========SON=========>>> İçerik SON */

                                    /* Stok ve Kod */
                                    if($_POST['upd_stok'] == '1') {
                                        $updStok = $key->$stoktag;
                                    }else{
                                        $updStok = $urun['stok'];
                                    }
                                    if($_POST['upd_stokkod'] == '1') {
                                        $updStokKod = $key->$stokkodtag;
                                    }else{
                                        $updStokKod = $urun['urun_kod'];
                                    }
                                    /*  <========SON=========>>> Stok ve Kod SON */

                                    /* Fiyat */
                                    if($_POST['upd_fiyat'] == '1') {
                                        $fiyatNe = $key->$fiyattag;
                                        if($_POST['upd_ek_oran'] >'0'  ) {
                                            $ekOran = $_POST['upd_ek_oran'];
                                            $fiyataEkle = kdvhesapla($fiyatNe,$ekOran);
                                            $updFiyat = $fiyatNe+$fiyataEkle;
                                        }else{
                                            $updFiyat = $fiyatNe;
                                        }
                                    }else{
                                        $updFiyat = $urun['fiyat'];
                                    }
                                    /*  <========SON=========>>> Fiyat SON */

                                    /* Foto */
                                    if($_POST['upd_foto'] == '1'  ) {

                                        $urunKutuAyar = $db->prepare("select resim_w,resim_h,resim_big_w,resim_big_h from urun_kutu where id='1' ");
                                        $urunKutuAyar->execute();
                                        $urunboxRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
                                        $resim_w = $urunboxRow['resim_w'];
                                        $resim_h = $urunboxRow['resim_h'];
                                        $resim_big_w = $urunboxRow['resim_big_w'];
                                        $resim_big_h = $urunboxRow['resim_big_h'];


                                        /* Ürün Fotoğrafı */
                                        if($key->$gorseltag  ) {
                                            $imgURL = $key->$gorseltag;
                                            $resim  =$imgURL;
                                            $img_name = '_img_';
                                            $imgFolderAndName = '../images/temp/'.$img_name.'.jpg';
                                            $ch = curl_init($imgURL);
                                            $fp = fopen($imgFolderAndName, 'wb');
                                            curl_setopt($ch, CURLOPT_FILE, $fp);
                                            curl_setopt($ch, CURLOPT_HEADER, 0);
                                            curl_exec($ch);
                                            curl_close($ch);
                                            fclose($fp);
                                            include_once('inc/class.upload.php');
                                            $upload = new Upload($imgFolderAndName);
                                            if ($upload->uploaded) {
                                                $random = rand(0, (int)99991234569);
                                                $random2 = rand(0, (int)999);
                                                $upload->file_name_body_pre = 'product_';
                                                $upload->file_name_body_add = ''.$random.''.$random2.'';
                                                $upload->image_resize = true;
                                                $upload->image_ratio_crop = true;
                                                $upload->png_quality = 90;
                                                $upload->webp_quality = 92;
                                                $upload->jpeg_quality = 92;
                                                $upload->png_compression = 9;
                                                $upload->image_x = $resim_big_w;
                                                $upload->image_y = $resim_big_h;
                                                $upload->process("../images/product/big_photo");

                                                $upload->file_name_body_pre = 'product_';
                                                $upload->file_name_body_add = ''.$random.''.$random2.'';
                                                $upload->image_resize = true;
                                                $upload->image_ratio_crop = true;
                                                $upload->png_quality = 90;
                                                $upload->webp_quality = 92;
                                                $upload->jpeg_quality = 92;
                                                $upload->png_compression = 9;
                                                $upload->image_x = $resim_w;
                                                $upload->image_y = $resim_h;
                                                $upload->process("../images/product");
                                            }
                                            if ($upload->processed){
                                                $updGorsel = $upload->file_dst_name;
                                                unlink(''.$imgFolderAndName.'');
                                                unlink('../images/product/'.$urun['gorsel'].'');
                                                unlink('../images/product/big_photo/'.$urun['gorsel'].'');
                                            }
                                        }else{
                                            $updGorsel = $urun['gorsel'];
                                        }
                                    }else{
                                        $updGorsel = $urun['gorsel'];
                                    }
                                    /*  <========SON=========>>> Foto SON */
                                    $guncelle = $db->prepare("UPDATE urun SET
                                    baslik=:baslik,
                                    seo_url=:seo_url,
                                    seo_baslik=:seo_baslik,
                                    icerik=:icerik,
                                    gorsel=:gorsel,
                                    stok=:stok,
                                    urun_kod=:urun_kod,
                                    fiyat=:fiyat,
                                    tarih=:tarih,
                                    sade_tarih=:sade_tarih,
                                    ekleyen=:ekleyen     
                                     WHERE xml_product_id={$key->$idtag}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'baslik' => $updBaslik,
                                        'seo_url' => $updSeo,
                                        'seo_baslik' => $updSeoTitle,
                                        'icerik' => $updAciklama,
                                        'gorsel' => $updGorsel,
                                        'stok' => $updStok,
                                        'urun_kod' => $updStokKod,
                                        'fiyat' => $updFiyat,
                                        'tarih' => $timestamp,
                                        'sade_tarih' => $sadetarih,
                                        'ekleyen' => $adminadi
                                    ));
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                                }
                                /*  <========SON=========>>> Güncelle SON */
                            }
                        }
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_import');
                        $_SESSION['main_alert'] = 'success';
                        exit();
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
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