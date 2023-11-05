<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
use Verot\Upload\Upload;
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'ty_settings' || $_GET['status']=='ty_eslestir' || $_GET['status']=='ty_urun_cek' || $_GET['status']=='ty_sistemden_urun_sil'|| $_GET['status']=='ty_ozellik' || $_GET['status']=='ty_marka_ekle' || $_GET['status']=='ty_tekguncelle' || $_GET['status']=='ty_aktarim') {

            if($_GET['status'] == 'ty_sistemden_urun_sil'  ) {
                if ($_POST  ) {
                    if($_POST['item_id']  ) {

                        foreach ($_POST['item_id'] as $item) {

                            $urunIMG = $db->prepare("select gorsel from urun where id=:id ");
                            $urunIMG->execute(array(
                                'id' => $item,
                            ));
                            $imgRow = $urunIMG->fetch(PDO::FETCH_ASSOC);


                            if($imgRow['gorsel'] == !null && $imgRow['gorsel'] != 'no-img.jpg' ) {
                                unlink('../images/product/'.$imgRow['gorsel'].'');
                                unlink('../images/product/big_photo/'.$imgRow['gorsel'].'');
                            }


                            /* varyantlar silinsin */
                            $silmeislem = $db->prepare("DELETE from detay_varyant WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            $silmeislem = $db->prepare("DELETE from detay_varyant_ozellik WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            /*  <========SON=========>>> varyantlar silinsin SON */

                            /* Detay Benzer Ürünler Sil */
                            $silmeislem = $db->prepare("DELETE from urundetay_benzer_urun WHERE detay_id=:detay_id");
                            $sil = $silmeislem->execute(array(
                                'detay_id' => $item
                            ));
                            /*  <========SON=========>>> Detay Benzer Ürünler Sil SON */

                            /* Favorilerden Sil */
                            $silmeislem = $db->prepare("DELETE from urun_favori WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            /*  <========SON=========>>> Favorilerden Sil SON */

                            /* galeri sil */
                            $galeriListesi = $db->prepare("select * from urun_galeri where urun_id=:urun_id ");
                            $galeriListesi->execute(array(
                                'urun_id' => $item
                            ));
                            if($galeriListesi->rowCount()>'0'  ) {
                                foreach ($galeriListesi as $galerisil){
                                    unlink('../images/product/'.$galerisil['gorsel'].'');
                                    $silmeislem = $db->prepare("DELETE from urun_galeri WHERE urun_id=:urun_id");
                                    $sil = $silmeislem->execute(array(
                                        'urun_id' => $item
                                    ));
                                }
                            }
                            /*  <========SON=========>>> galeri sil SON */

                            /* Yorum Sil */
                            $silmeislem = $db->prepare("DELETE from urun_yorum WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            /*  <========SON=========>>> Yorum Sil SON */

                            /* Teknik Özellik Sil */
                            $silmeislem = $db->prepare("DELETE from filtre_ozellik WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            $silmeislem = $db->prepare("DELETE from filtre_ozellik_grup WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            /*  <========SON=========>>> Teknik Özellik Sil SON */

                            /* Vitrinlerden Sil */
                            $silmeislem = $db->prepare("DELETE from vitrin_firsat_urunler WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            $silmeislem = $db->prepare("DELETE from vitrin_tip1_urunler WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                            ));
                            /*  <========SON=========>>> Vitrinlerden Sil SON */

                            $silmeislem = $db->prepare("DELETE from urun WHERE id=:id");
                            $sil = $silmeislem->execute(array(
                                'id' => $item
                            ));
                            if($sil) {
                                $silmeislem = $db->prepare("DELETE from trendyol_urun_bilgi WHERE urun_id=:urun_id");
                                $sil = $silmeislem->execute(array(
                                'urun_id' => $item
                                ));
                            }
                        }
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=ty_process');
                        exit();
                    }else{
                        $_SESSION['main_alert'] = 'nocheck';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=ty_process');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }


            $urunKutuAyar = $db->prepare("select resim_w,resim_h,resim_big_w,resim_big_h from urun_kutu where id='1' ");
            $urunKutuAyar->execute();
            $urunboxRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
            $resim_w = $urunboxRow['resim_w'];
            $resim_h = $urunboxRow['resim_h'];
            $resim_big_w = $urunboxRow['resim_big_w'];
            $resim_big_h = $urunboxRow['resim_big_h'];


            if($_GET['status'] == 'ty_urun_cek'  ) {
                if ($_POST && $_POST['cek'] == '1' && isset($_POST['save'])) {
                    $limit = $_POST['cek_limit'];
                    $katolustur = $_POST['cek_kat'];
                    $timestamp = date('00:00:00');
                    $pages = $_POST['sayfa'];
                    $start_s = $_POST['cek_start'].' '.$timestamp;
                    $end_s = $_POST['cek_end'].' '.$timestamp;
                    $start = strtotime($start_s)* 1000;
                    $end = strtotime($end_s)* 1000;
                   if($limit ) {
                    if($limit >= '1'  ) {
                        if($limit <= '500'  ) {

                            $pazarSql = $db->prepare("select * from pazaryeri where id=:id ");
                            $pazarSql->execute(array(
                                'id' => '1'
                            ));
                            $pazar = $pazarSql->fetch(PDO::FETCH_ASSOC);
                            if($pazar['ty_durum'] !='1' ) {
                             header('Location:'.$ayar['site_url'].'404');
                             exit();
                            }
                            $bayino = $pazar['ty_bayi'];
                            $api = $pazar['ty_api'];
                            $secret = $pazar['ty_secret'];



                            $supplierId = ''.$bayino.'';
                            $username = ''.$api.'';
                            $password = ''.$secret.'';
                            $authorization = base64_encode($username . ':' . $password);

                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$bayino.'/products?approved=true&onSale=true&page='.$pages.'&size='.$limit.'',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 100,
                                CURLOPT_TIMEOUT =>0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'GET',
                                CURLOPT_HTTPHEADER => array(
                                    'User-Agent: ' . $supplierId . ' - SelfIntegration',
                                    'Authorization: Basic ' . $authorization,
                                )
                            ));
                            $urunleriGetir = curl_exec($curl);
                            curl_close($curl);
                            $json = json_decode($urunleriGetir);
                            $jsonSorgu = json_decode($urunleriGetir,true);



                            if($jsonSorgu['totalElements'] == '0'  ) {
                                $_SESSION['main_alert']='ty_export_nothing';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=ty_process');
                                exit();
                            }else{
                                foreach ($json->content as $a){
                                    $UruNVarmi = $db->prepare("select id from urun where barkod=:barkod ");
                                    $UruNVarmi->execute(array(
                                        'barkod' => $a->barcode,
                                    ));
                                    if($UruNVarmi->rowCount()<='0'  ) {
                                    $first = '1';
                                    /* Urunu Ekle */
                                    $seo_url = seo($a->title);
                                    $ekleyen = $adminRow['user_adi'];
                                    $descfor = trim(strip_tags($a->description));
                                    /* Kategori İşlemi */
                                        $kategoriAdi = $a->categoryName;
                                        $kategoriSorgu = $db->prepare("select * from urun_cat where baslik like '$kategoriAdi'");
                                        $kategoriSorgu->execute();
                                        if($kategoriSorgu->rowCount()>'0'  ) {
                                            $katRow = $kategoriSorgu->fetch(PDO::FETCH_ASSOC);
                                            $kategoriIDNo = $katRow['id'];
                                        }else{
                                            if($katolustur == '1'  ) {
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
                                                    $kategoriIDNo = $sonkatRow['id'];
                                                }else{
                                                    $kategoriIDNo = '0';
                                                }
                                            }else{
                                                $kategoriIDNo = '0';
                                            }
                                        }
                                    /* Kategori işlemi SON*/

                                    /* Ürün Görseli */
                                    foreach ($a->images as $i){
                                        if($first == '1'  ) {
                                            $imgURL = $i->url;
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
                                                $upload->image_ratio_fill      = 'C';
                                                $upload->image_x = $resim_w;
                                                $upload->image_y = $resim_h;
                                                $upload->process("../images/product");
                                            }
                                            if ($upload->processed){
                                                $gorsel = $upload->file_dst_name;
                                                unlink(''.$imgFolderAndName.'');
                                            }
                                            $first = '0';
                                        }

                                    }
                                    /*  <========SON=========>>> Ürün Görseli SON */



                                        /* Ürün Varyantını başlığa al BEDEN İÇİN*/
                                        foreach ($a->attributes as $varya){
                                            if($varya->attributeName == 'Beden'  ) {
                                                $varyant_value=  '- '.$varya->attributeValue.'';
                                            }
                                        }
                                        /*  <========SON=========>>> Ürün Varyantını başlığa al SON */


                                    $kaydet = $db->prepare("INSERT INTO urun SET
                                       dil=:dil,     
                                       durum=:durum,
                                       gorunmez=:gorunmez,
                                       siparis_islem=:siparis_islem,
                                       yeni=:yeni,
                                       baslik=:baslik,
                                       tarih=:tarih,
                                       sade_tarih=:sade_tarih,
                                       urun_kod=:urun_kod,
                                       stok=:stok,
                                       barkod=:barkod,
                                       icerik=:icerik,
                                       meta_desc=:meta_desc,
                                       fiyat_goster=:fiyat_goster,
                                       havale_indirim_tur=:havale_indirim_tur,
                                       havale_indirim_tutar=:havale_indirim_tutar,
                                       fiyat=:fiyat,
                                       kdv=:kdv,
                                       kdv_oran=:kdv_oran,
                                       kargo=:kargo,
                                       kargo_tipi=:kargo_tipi,
                                       kargo_ucret=:kargo_ucret,
                                       yorum_durum=:yorum_durum,
                                       taksit=:taksit,
                                       anasayfa=:anasayfa,
                                       seo_url=:seo_url,
                                       satis_adet=:satis_adet,
                                       ekleyen=:ekleyen,
                                       pazaryeri_adi=:pazaryeri_adi,
                                       seo_baslik=:seo_baslik,
                                       gorsel=:gorsel,
                                       kat_id=:kat_id,
                                       iliskili_kat=:iliskili_kat
                                    ");
                                    $sonuc = $kaydet->execute(array(
                                        'dil' => $_SESSION['dil'],
                                        'durum' => '1',
                                        'gorunmez' => '0',
                                        'siparis_islem' => '0',
                                        'yeni' => '1',
                                        'baslik' => ''.$a->title.' '.$varyant_value.'',
                                        'tarih' => date("Y-m-d H:i:s", ($a->createDateTime / 1000) ),
                                        'sade_tarih' => date("Y-m-d", ($a->createDateTime / 1000) ),
                                        'urun_kod' => $a->stockCode,
                                        'stok' => $a->quantity,
                                        'barkod' => $a->barcode,
                                        'icerik' => $a->description,
                                        'meta_desc' => $descfor,
                                        'fiyat_goster' => '1',
                                        'havale_indirim_tur' => '1',
                                        'havale_indirim_tutar' => '0',
                                        'fiyat' => $a->salePrice,
                                        'kdv' => '2',
                                        'kdv_oran' => $a->vatRate,
                                        'kargo' => '0',
                                        'kargo_tipi' => '0',
                                        'kargo_ucret' => '0',
                                        'yorum_durum' => '1',
                                        'taksit' => $pazar['ty_taksit'],
                                        'anasayfa' => '1',
                                        'seo_url' => $seo_url,
                                        'satis_adet' => '0',
                                        'ekleyen' => $ekleyen,
                                        'pazaryeri_adi' => 'trendyol',
                                        'seo_baslik' => $a->title,
                                        'gorsel' => $gorsel,
                                        'kat_id' => $kategoriIDNo,
                                        'iliskili_kat' => $kategoriIDNo
                                    ));
                                    if($sonuc){
                                        /* Trendyol Listesine Ekle (trendyol_urun_bilgi) */
                                        $lastProduct = $db->prepare("select id from urun order by id desc limit 1");
                                        $lastProduct->execute();
                                        $LastProductRow = $lastProduct->fetch(PDO::FETCH_ASSOC);
                                        $urunID = $LastProductRow['id'];
                                        $kaydet = $db->prepare("INSERT INTO trendyol_urun_bilgi SET
                                                    ty_kod=:ty_kod,
                                                    ty_kuyruk=:ty_kuyruk,
                                                    urun_id=:urun_id,
                                                    ty_aktarim=:ty_aktarim,
                                                    ty_log=:ty_log,
                                                    ty_tarih=:ty_tarih,
                                                    ty_izin=:ty_izin,
                                                    ty_stok=:ty_stok,
                                                    ty_fiyat=:ty_fiyat,
                                                    ty_kat=:ty_kat,
                                                    ty_marka=:ty_marka
                                            ");
                                        $sonuc = $kaydet->execute(array(
                                            'ty_kod' => $a->barcode,
                                            'ty_kuyruk' => '1',
                                            'urun_id' => $urunID,
                                            'ty_aktarim' => '1',
                                            'ty_log' => '0',
                                            'ty_tarih' => date("Y-m-d H:i:s", ($a->createDateTime / 1000) ),
                                            'ty_izin' => '1',
                                            'ty_stok' => $a->quantity,
                                            'ty_fiyat' => $a->salePrice,
                                            'ty_kat' => $a->pimCategoryId,
                                            'ty_marka' => $a->brandId
                                        ));
                                        /*  <========SON=========>>> Trendyol Listesine Ekle (trendyol_urun_bilgi) SON */
                                    }
                                    /*  <========SON=========>>> Urunu Ekle SON */

                                }
                                }
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=ty_process');
                            }
                            // foreach ile ürünleri urun tablosuna aktar ve aynı zamanda trendyol_urun_bilgi tablosuna da aktar.

                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                            exit();
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                   }else{
                       header('Location:'.$ayar['site_url'].'404');
                       exit();
                   }
                }
            }

            if($_GET['status'] == 'ty_aktarim'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['product_id']) {
                    $Sorgu = $db->prepare("select * from trendyol_urun_bilgi where urun_id=:urun_id ");
                    $Sorgu->execute(array(
                        'urun_id' => $_POST['product_id'],
                    ));
                    if($Sorgu->rowCount()>'0'  ) {
                        $bilgi = $Sorgu->fetch(PDO::FETCH_ASSOC);
                        $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
                        $pazarYeri->execute();
                        $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
                        $bayino = $pazar['ty_bayi'];
                        $api = $pazar['ty_api'];
                        $secret = $pazar['ty_secret'];
                        $urun = $db->prepare("select * from urun where id=:id ");
                        $urun->execute(array(
                            'id' => $_POST['product_id']
                        ));
                        if($urun->rowCount()<='0'  ) {
                            header('Location:'.$ayar['site_url'].'404');
                            exit();
                        }
                        $row = $urun->fetch(PDO::FETCH_ASSOC);
                        $baslik = $row['baslik'];
                        $stokkodu = $row['urun_kod'];
                        $markaID = $bilgi['ty_marka'];
                        $categoryID = $bilgi['ty_kat'];
                        $adet = $_POST['stok'];
                        $IDproduct = $row['id'];
                        $kdvorancek = $row['kdv_oran'];
                        $resim = ''.$ayar['site_url'].'images/product/'.$row['gorsel'].'';
                        if($kdvorancek <='0'  ) {
                            $kdvoran = '18';
                        }else{
                            $kdvoran = $kdvorancek;
                        }

                        /* Barkod */
                        if($row['barkod'] == !null ) {
                            $barkodGetir = $row['barkod'];
                        }else{
                            $barkodGetir = $row['urun_kod'];
                        }
                        /*  <========SON=========>>> Barkod SON */

                        $oran = $_POST['ek_oran'];
                        $satisfiyat = $row['fiyat'];

                        if($oran>'0'  ) {
                            $oranfiyat = kdvhesapla($satisfiyat,$oran);
                            $fiyat = $satisfiyat+$oranfiyat;
                        }else{
                            $fiyat = $satisfiyat;
                        }

                        $veri = $bilgi['ty_ozellik'];
                        $verim = $veri;
                        $verim = explode('|', $verim);

                        foreach ($verim as $v){
                            $v2 = $v;
                            $v2 = explode('_', $v2);
                            foreach ($v2 as $a =>$key){
                                if($key !='' && $a == '0') {
                                    if(is_numeric($v2[1])  ) {
                                        $siparisler[]=
                                            ['attributeId' => "$v2[0]",'attributeValueId' => "$v2[1]"];
                                    }else{
                                        $siparisler[]=
                                            ['attributeId' => "$v2[0]",'customAttributeValue' => "$v2[1]"];
                                    }
                                }
                            }
                        }
                        $sip = json_encode($siparisler);


                        if($row['icerik'] == !null  ) {
                            $icerik_cek  = $row['icerik'];
                            $eski   = '../i/';
                            $yeni   = ''.$ayar['site_url'].'i/';
                            $icerik_cek = str_replace($eski, $yeni, $icerik_cek);
                            $icerik = $icerik_cek;
                        }else{
                            $icerik = $baslik;
                        }

                        //$resim = 'https://premiumshop11.demodeposu.com/images/product/product_kapsonlu-salas-elbise-530gk-12021-taba-308795-53-O74994369935409.png';

                        $url = 'https://api.trendyol.com/sapigw/suppliers/'.$bayino.'/v2/products';
                        $ch = curl_init($url);
                        $json='{
                                  "items": [
                                    {
                                      "barcode": "'.$barkodGetir.'",
                                      "title": "'.$baslik.'",
                                      "productMainId": "'.$IDproduct.'",
                                      "brandId": '.$markaID.',
                                      "categoryId": '.$categoryID.',
                                      "quantity": '.$adet.',
                                      "stockCode": "'.$stokkodu.'",
                                      "dimensionalWeight": 1,
                                      "description": "'.$icerik.'",
                                      "currencyType": "TRY",
                                      "listPrice": '.$fiyat.',
                                      "salePrice": '.$fiyat.',
                                      "vatRate": '.$kdvoran.',
                                      "cargoCompanyId": '.$pazar['ty_kargo'].',
                                          "attributes": 
                                            '.$sip.'
                                          ,
                                      "images": [
                                        {
                                          "url": "'.$resim.'"
                                        }
                                      ]
                                    }
                                  ]
                               } ';


                        curl_setopt($ch, CURLOPT_POST, 1);
                        $header = array(
                            'Authorization: Basic '. base64_encode(''.$api.':'.$secret.''),
                            'Content-Type: application/json'
                        );
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        $json = json_decode($result,true);

                        if(isset($json['errors'][0])  ) {
                            /* Ürün başarısız. Mesajı log kaydına ekle. */
                            if(isset($json['errors'][0]['message'])  ) {
                                $errormesaj = json_encode($json['errors'][0]['message']);
                            }else{
                                $errormesaj = 'Hatalar var! <br>Kategori veya marka seçiminizi kontrol edin.<br>Ayrıca kategori özelliklerinizi seçmeyi unutmayın.<br>Ayrıca ürün açıklamanızı, barkodunuzu ve stok kodunuzu da girdiğinizden emin olun.';
                            }
                            $timestamp = date('Y-m-d G:i:s');
                            $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_log=:ty_log,
                                    ty_tarih=:ty_tarih
                             WHERE urun_id={$_POST['product_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'ty_log' => $errormesaj,
                                'ty_tarih' => $timestamp,
                            ));
                            $_SESSION['main_alert'] = 'ty_tekekleme_hata';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_POST['product_id'].'');
                        }else{
                            /* Başarılı */
                            $authorization = base64_encode($api . ':' . $secret);
                            $curl = curl_init();
                            curl_setopt_array($curl, array(

                                CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$bayino.'/products/batch-requests/'.$json['batchRequestId'].'',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT =>0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'GET',
                                CURLOPT_HTTPHEADER => array(
                                    'User-Agent: ' . $bayino . ' - SelfIntegration',
                                    'Authorization: Basic ' . $authorization,
                                )
                            ));
                            $kontrolSonuc = curl_exec($curl);
                            curl_close($curl);
                            $json = json_decode($kontrolSonuc);
                            $jsons = json_decode($kontrolSonuc,true);


                            if($jsons['status'] == 'SUCCESS' || $jsons['status'] == 'IN_PROGRESS' || $jsons['status'] == 'COMPLETED') {
                                $timestamp = date('Y-m-d G:i:s');
                                $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_aktarim=:ty_aktarim,
                                    ty_kod=:ty_kod,
                                    ty_log=:ty_log,
                                    ty_tarih=:ty_tarih,
                                    ty_stok=:ty_stok,
                                    ty_fiyat=:ty_fiyat
                             WHERE urun_id={$_POST['product_id']}      
                            ");
                                $sonuc = $guncelle->execute(array(
                                    'ty_aktarim' => '1',
                                    'ty_kod' => $barkodGetir,
                                    'ty_log' => '0',
                                    'ty_tarih' => $timestamp,
                                    'ty_stok' => $adet,
                                    'ty_fiyat' => $fiyat
                                ));
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_POST['product_id'].'');
                            }else{
                                $timestamp = date('Y-m-d G:i:s');
                                $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_log=:ty_log,
                                    ty_tarih=:ty_tarih
                             WHERE urun_id={$_POST['product_id']}      
                            ");
                                $sonuc = $guncelle->execute(array(
                                    'ty_log' => json_encode($jsons['items'][0]['failureReasons']),
                                    'ty_tarih' => $timestamp,
                                ));
                                $_SESSION['main_alert'] = 'ty_tekekleme_hata';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_POST['product_id'].'');
                            }

                        }


                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }




                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'ty_tekguncelle'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['bilgi_id']) {
                    $sorgula = $db->prepare("select * from trendyol_urun_bilgi where id=:id ");
                    $sorgula->execute(array(
                        'id' => $_POST['bilgi_id'],
                    ));
                    $bilgi = $sorgula->fetch(PDO::FETCH_ASSOC);
                    $pazarYeri = $db->prepare("select * from pazaryeri where id='1' ");
                    $pazarYeri->execute();
                    $pazar = $pazarYeri->fetch(PDO::FETCH_ASSOC);
                    $bayino = $pazar['ty_bayi'];
                    $api = $pazar['ty_api'];
                    $secret = $pazar['ty_secret'];
                    $adet = $_POST['stok'];
                    $fiyat = $_POST['fiyat'];
                    $barkod = $bilgi['ty_kod'];
                    $url = 'https://api.trendyol.com/sapigw/suppliers/'.$bayino.'/products/price-and-inventory';
                    $ch = curl_init($url);
                    $json='{
                          "items": [
                            {
                              "barcode": "'.$barkod.'",
                              "quantity": '.$adet.',
                              "salePrice": '.$fiyat.',
                              "listPrice": '.$fiyat.'
                            }
                          ]
                        }';
                    curl_setopt($ch, CURLOPT_POST, 1);
                    $header = array(
                        'Authorization: Basic '. base64_encode(''.$api.':'.$secret.''),
                        'Content-Type: application/json'
                    );
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    $json = json_decode($result,true);
                    if(isset($json['errors'][0])  ) {
                        /* Ürün başarısız. Mesajı log kaydına ekle. */
                        echo $json['errors'][0]['message'];
                    }else{
                        $supplierId = ''.$bayino.''; // Buraya trendyol tarafından size verilen tedarikçi ID yazılır.
                        $username = ''.$api.''; // api kullanıcı adı
                        $password = ''.$secret.''; // api şifre
                        $authorization = base64_encode($username . ':' . $password);
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://api.trendyol.com/sapigw/suppliers/'.$supplierId.'/products/batch-requests/'.$json['batchRequestId'].'',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT =>0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'User-Agent: ' . $supplierId . ' - SelfIntegration',
                                'Authorization: Basic ' . $authorization,
                            )
                        ));
                        $kontrolSonuc = curl_exec($curl);
                        curl_close($curl);
                        $json = json_decode($kontrolSonuc);
                        $jsons = json_decode($kontrolSonuc,true);
                        if($jsons['items'][0]['status'] == 'SUCCESS'  ) {
                            $timestamp = date('Y-m-d G:i:s');
                            $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                    ty_tarih=:ty_tarih,
                                    ty_stok=:ty_stok,
                                    ty_fiyat=:ty_fiyat
                             WHERE id={$_POST['bilgi_id']}      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'ty_tarih' => $timestamp,
                                'ty_stok' => $_POST['stok'],
                                'ty_fiyat' => $_POST['fiyat']
                            ));
                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$bilgi['urun_id'].'');
                        }else{
                            $_SESSION['main_alert'] = 'ty_guncelleme_hata';
                            $_SESSION['ty_guncelleme_hata'] = $jsons['items'][0]['failureReasons'];
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$bilgi['urun_id'].'');
                        }
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'ty_marka_ekle'  ) {
                if ($_POST && isset($_POST['attAdd'])) {


                    if($_POST['return'] == 'category'  ) {
                        $markapost = $_POST['ty_marka_post'];
                        $markaayir = $markapost;
                        $markaayir = explode('_', $markaayir);

                        foreach ($markaayir as $m =>$k){
                            if($k !='' && $m == '0') {
                                $marka = $markaayir[0];
                                $marka_adi = $markaayir[1];
                            }
                        }

                        $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                            ty_marka=:ty_marka,
                            ty_marka_adi=:ty_marka_adi
                     WHERE ty_kat={$_POST['ty_kat_id']}      
                    ");
                        $sonuc = $guncelle->execute(array(
                            'ty_marka' => $marka,
                            'ty_marka_adi' => $marka_adi
                        ));
                        
                        $guncelle = $db->prepare("UPDATE urun_cat SET
                                  ty_marka=:ty_marka,
                            ty_marka_adi=:ty_marka_adi
                         WHERE id={$_POST['cat_id']}      
                        ");
                        $sonuc = $guncelle->execute(array(
                            'ty_marka' => $marka,
                            'ty_marka_adi' => $marka_adi
                        ));

                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=ty_sync&catID='.$_POST['cat_id'].'');
                    }


                    if($_POST['return'] == 'product'  ) {
                        $markapost = $_POST['ty_marka_post'];
                        $markaayir = $markapost;
                        $markaayir = explode('_', $markaayir);

                        foreach ($markaayir as $m =>$k){
                            if($k !='' && $m == '0') {
                                $marka = $markaayir[0];
                                $marka_adi = $markaayir[1];
                            }
                        }

                        $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                            ty_marka=:ty_marka,
                            ty_marka_adi=:ty_marka_adi
                     WHERE urun_id={$_POST['urun_id']}      
                    ");
                        $sonuc = $guncelle->execute(array(
                            'ty_marka' => $marka,
                            'ty_marka_adi' => $marka_adi
                        ));

                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_POST['urun_id'].'');
                    }


                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'ty_ozellik'  ) {
                if ($_POST && isset($_POST['attAdd']) && $_POST['cat_id']) {
                    if($_POST['return'] == 'category' || $_POST['return'] == 'product'   ) {
                        if($_POST['return'] == 'category'  ) {
                            $catSorgu = $db->prepare("select * from urun_cat where id=:id ");
                            $catSorgu->execute(array(
                                'id' => $_POST['cat_id']
                            ));
                            if($catSorgu->rowCount()<='0'  ) {
                                header('Location:'.$ayar['site_url'].'404');
                                exit();
                            }
                            $ozellik = $_POST['ozellik'];
                            foreach ($ozellik as $oz => $key){
                                if($key == !null  ) {
                                 $ozellikdb.=''.$oz.'_'.$key.'|';
                                }
                            }

                            $guncelle = $db->prepare("UPDATE urun_cat SET
                            ty_ozellik=:ty_ozellik
                     WHERE id={$_POST['cat_id']}      
                    ");
                            $sonuc = $guncelle->execute(array(
                                'ty_ozellik' => $ozellikdb
                            ));
                            if($sonuc){
                                $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                      ty_ozellik=:ty_ozellik   
                                 WHERE ty_kat={$_POST['ty_kat_id']}      
                                ");
                                $sonuc = $guncelle->execute(array(
                                    'ty_ozellik' => $ozellikdb
                                ));
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=ty_sync&catID='.$_POST['cat_id'].'');
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                        }else{

                         $urunID = $_POST['urun_id'];

                            $ozellik = $_POST['ozellik'];
                            foreach ($ozellik as $oz => $key){
                                if($key == !null  ) {
                                    $ozellikdb.=''.$oz.'_'.$key.'|';
                                }
                            }

                            $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                      ty_ozellik=:ty_ozellik   
                                 WHERE urun_id={$urunID}      
                                ");
                            $sonuc = $guncelle->execute(array(
                                'ty_ozellik' => $ozellikdb
                            ));


                            $_SESSION['main_alert'] = 'success';
                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$_POST['urun_id'].'');
                            /*  <========SON=========>>> ürün için SON */




                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'ty_settings'  ) {
                if($_POST && isset($_POST['settingSave'])  ) {


                    if($_POST['ty_cat_update']  ) {
                     /* Trendyol kategorilerini json olarak indir */
                        $botName = 'assets/ty/catlist/kategoriler.php';
                        $contents = file_get_contents('https://api.trendyol.com/sapigw/product-categories');
                        $okay = file_put_contents($botName, $contents);
                     /*  <========SON=========>>> Trendyol kategorilerini json olarak indir SON */
                    }


                    $guncelle = $db->prepare("UPDATE pazaryeri SET
                          ty_durum=:ty_durum,
                          ty_bayi=:ty_bayi,
                          ty_taksit=:ty_taksit,
                          ty_api=:ty_api,
                          ty_secret=:ty_secret,
                          ty_kargo=:ty_kargo
                   WHERE id='1'      
                  ");
                    $sonuc = $guncelle->execute(array(
                        'ty_durum' => $_POST['ty_durum'],
                        'ty_bayi' => $_POST['ty_bayi'],
                        'ty_taksit' => $_POST['ty_taksit'],
                        'ty_api' => $_POST['ty_api'],
                        'ty_secret' => $_POST['ty_secret'],
                        'ty_kargo' => $_POST['ty_kargo']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=ty_settings');
                    }else{
                        echo 'Veritabanı Hatası';
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

            if($_GET['status'] == 'ty_eslestir'  ) {
                if ($_POST && isset($_POST['save']) && $_POST['cat_id'] && $_POST['return']) {
                    if($_POST['return'] == 'category' || $_POST['return'] == 'product'  ) {


                        if($_POST['return']=='product'  ) {
                            if($_POST['product_id'] == !null  ) {
                                $proID = $_POST['product_id'];
                            }else{
                                $proID = null;
                            }
                        }


                        if($_POST['category_sub']  ) {

                            $katID = $_POST['category_sub'];

                            /* Kategori Tam Adı */
                            $anakat_name = $_POST['anakategori_adi'];
                            $name1= $_POST['altkat_1_adi'];
                            $name2= $_POST['altkat_2_adi'];
                            $name3= $_POST['altkat_3_adi'];
                            $name4= $_POST['altkat_4_adi'];
                            $name5= $_POST['altkat_5_adi'];

                            if($anakat_name == !null  ) {
                             $kat_long_name.=''.$anakat_name.'';
                            }
                            if($name1 == !null  ) {
                                $kat_long_name.=' > '.$name1.'';
                            }
                            if($name2 == !null  ) {
                                $kat_long_name.=' > '.$name2.'';
                            }
                            if($name3 == !null  ) {
                                $kat_long_name.=' > '.$name3.'';
                            }
                            if($name4 == !null  ) {
                                $kat_long_name.=' > '.$name4.'';
                            }
                            if($name5 == !null  ) {
                                $kat_long_name.=' > '.$name5.'';
                            }
                            /*  <========SON=========>>> Kategori Tam Adı SON */


                            if($_POST['return'] == 'category') {
                                $guncelle = $db->prepare("UPDATE urun_cat SET
                                         ty_kat=:ty_kat,
                                         ty_marka=:ty_marka,
                                         ty_marka_adi=:ty_marka_adi,
                                         ty_ozellik=:ty_ozellik,
                                         ty_kat_adi=:ty_kat_adi
                                  WHERE id={$_POST['cat_id']}      
                                 ");
                                $sonuc = $guncelle->execute(array(
                                    'ty_kat' => $katID,
                                    'ty_marka' => '0',
                                    'ty_marka_adi' => '0',
                                    'ty_ozellik' => '0',
                                    'ty_kat_adi' => $kat_long_name
                                ));
                                
                                $urunForla = $db->prepare("select id from urun where iliskili_kat=:iliskili_kat and durum=:durum ");
                                $urunForla->execute(array(
                                    'iliskili_kat' => $_POST['cat_id'],
                                    'durum' => '1'
                                ));
                                
                                foreach ($urunForla as $urunfor){
                                     $varmi = $db->prepare("select * from trendyol_urun_bilgi where urun_id=:urun_id ");
                                     $varmi->execute(array(
                                         'urun_id' => $urunfor['id']
                                     ));
                                     if($varmi->rowCount()<='0'  ) {
                                      /* Bu ürün eklenmemiş insertle bilgi tablosuna */
                                        $kaydet = $db->prepare("INSERT INTO trendyol_urun_bilgi SET
                                              urun_id=:urun_id,  
                                              ty_kat=:ty_kat,
                                              ty_marka=:ty_marka,
                                              ty_marka_adi=:ty_marka_adi,
                                              ty_ozellik=:ty_ozellik,
                                              ty_kat_adi=:ty_kat_adi,
                                              ty_kuyruk=:ty_kuyruk,
                                              ty_aktarim=:ty_aktarim,
                                              ty_log=:ty_log,
                                              ty_kod=:ty_kod,
                                              ty_izin=:ty_izin
                                        ");
                                        $sonuc = $kaydet->execute(array(
                                            'urun_id' => $urunfor['id'],
                                            'ty_kat' => $katID,
                                            'ty_marka' => '0',
                                            'ty_marka_adi' => '0',
                                            'ty_ozellik' => '0',
                                            'ty_kat_adi' => $kat_long_name,
                                            'ty_kuyruk' => '1',
                                            'ty_aktarim' => '0',
                                            'ty_log' => '0',
                                            'ty_kod' => '0',
                                            'ty_izin' => '1'
                                        ));
                                     }else{
                                         /* Bu ürün zaten var! Mevcut bilgilerini updatele */
                                         $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                              ty_kat=:ty_kat,
                                              ty_marka=:ty_marka,
                                              ty_marka_adi=:ty_marka_adi,
                                              ty_ozellik=:ty_ozellik,
                                              ty_kat_adi=:ty_kat_adi,
                                              ty_kuyruk=:ty_kuyruk,
                                              ty_aktarim=:ty_aktarim,
                                                      ty_log=:ty_log,
                                              ty_kod=:ty_kod,
                                              ty_izin=:ty_izin   
                                          WHERE urun_id={$urunfor['id']}      
                                         ");
                                         $sonuc = $guncelle->execute(array(
                                             'ty_kat' => $katID,
                                             'ty_marka' => '0',
                                             'ty_marka_adi' => '0',
                                             'ty_ozellik' => '0',
                                             'ty_kat_adi' => $kat_long_name,
                                             'ty_kuyruk' => '1',
                                             'ty_aktarim' => '0',
                                             'ty_log' => '0',
                                             'ty_kod' => '0',
                                             'ty_izin' => '1'
                                         ));
                                         /*  <========SON=========>>> Bu ürün zaten var! Mevcut bilgilerini updatele SON */
                                     }
                                }
                            }


                            $botName = 'assets/ty/ozellik/'.$katID.'.php';
                            $contents = file_get_contents('https://api.trendyol.com/sapigw/product-categories/'.$katID.'/attributes');
                            $okay = file_put_contents($botName, $contents);


                            if($_POST['return'] == 'product'  ) {

                                $varmi = $db->prepare("select * from trendyol_urun_bilgi where urun_id=:urun_id ");
                                $varmi->execute(array(
                                    'urun_id' => $proID
                                ));
                                if($varmi->rowCount()<='0'  ) {
                                    /* Bu ürün eklenmemiş insertle bilgi tablosuna */
                                    $kaydet = $db->prepare("INSERT INTO trendyol_urun_bilgi SET
                                              urun_id=:urun_id,  
                                              ty_kat=:ty_kat,
                                              ty_marka=:ty_marka,
                                              ty_marka_adi=:ty_marka_adi,
                                              ty_ozellik=:ty_ozellik,
                                              ty_kat_adi=:ty_kat_adi,
                                              ty_kuyruk=:ty_kuyruk,
                                              ty_aktarim=:ty_aktarim,
                                              ty_izin=:ty_izin
                                        ");
                                    $sonuc = $kaydet->execute(array(
                                        'urun_id' => $urunfor['id'],
                                        'ty_kat' => $katID,
                                        'ty_marka' => '0',
                                        'ty_marka_adi' => '0',
                                        'ty_ozellik' => '0',
                                        'ty_kat_adi' => $kat_long_name,
                                        'ty_kuyruk' => '1',
                                        'ty_aktarim' => '0',
                                        'ty_izin' => '1'
                                    ));
                                }else{
                                    /* Bu ürün zaten var! Mevcut bilgilerini updatele */
                                    $guncelle = $db->prepare("UPDATE trendyol_urun_bilgi SET
                                              ty_kat=:ty_kat,
                                              ty_marka=:ty_marka,
                                              ty_marka_adi=:ty_marka_adi,
                                              ty_ozellik=:ty_ozellik,
                                              ty_kat_adi=:ty_kat_adi,
                                              ty_kuyruk=:ty_kuyruk,
                                              ty_aktarim=:ty_aktarim,
                                              ty_izin=:ty_izin   
                                          WHERE urun_id={$proID}      
                                         ");
                                    $sonuc = $guncelle->execute(array(
                                        'ty_kat' => $katID,
                                        'ty_marka' => '0',
                                        'ty_marka_adi' => '0',
                                        'ty_ozellik' => '0',
                                        'ty_kat_adi' => $kat_long_name,
                                        'ty_kuyruk' => '1',
                                        'ty_aktarim' => '0',
                                        'ty_izin' => '1'
                                    ));
                                    /*  <========SON=========>>> Bu ürün zaten var! Mevcut bilgilerini updatele SON */
                                }

                            }


                            if($_POST['return'] == 'category'  ) {
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=ty_sync&catID='.$_POST['cat_id'].'');
                            }
                            if($_POST['return'] == 'product'  ) {
                                $_SESSION['main_alert'] = 'success';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$proID.'');
                            }


                        }else{
                            if($_POST['return'] == 'category'  ) {
                                $_SESSION['main_alert'] = 'altkatsec';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=ty_sync&catID='.$_POST['cat_id'].'');
                            }
                            if($_POST['return'] == 'product'  ) {
                                $_SESSION['main_alert'] = 'altkatsec';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_entegration_ty&productID='.$proID.'');
                            }
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                        exit();
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                    exit();
                }
            }

        }else{
            header('Location:'.$ayar['site_url'].'404');
            exit();
        }
    }
}else{
    header('Location:'.$_SESSION['current_url'] .'');
    $_SESSION['main_alert'] = 'demo';
}
