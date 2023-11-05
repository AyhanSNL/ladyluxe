<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
use Verot\Upload\Upload;
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'product_add' || $_GET['status'] == 'product_gallery' || $_GET['status'] == 'product_post' || $_GET['status'] == 'product_delete' || $_GET['status'] == 'multidelete' ) {




            function productControl($d)
            {
                global $db;
                global $ayar;
                global $row;
                global $Sql;
                $Sql = $db->prepare("select id,baslik,ozellikler,kat_id,gorsel from urun where id=:id ");
                $Sql->execute(array(
                    'id' => $d,
                ));
                $row = $Sql->fetch(PDO::FETCH_ASSOC);

                return;
            }


            if($_GET['status'] == 'multidelete'  ) {
                   if($_POST) {
                       if($_POST['sil'] <='0'  ) {
                           $_SESSION['main_alert'] ='nocheck';
                           header('Location:'.$ayar['panel_url'].'pages.php?page=products');
                       }else{
                           $liste = $_POST['sil'];
                           foreach ($liste as $idler){
                               $sorgu = $db->prepare("select * from urun where id='$idler' ");
                               $sorgu->execute();
                               if($sorgu->rowCount()>'0'  ) {
                                   $row = $sorgu->fetch(PDO::FETCH_ASSOC);


                                   /* varyantlar silinsin */
                                   $silmeislem = $db->prepare("DELETE from detay_varyant WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   $silmeislem = $db->prepare("DELETE from detay_varyant_ozellik WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   /*  <========SON=========>>> varyantlar silinsin SON */

                                   /* Detay Benzer Ürünler Sil */
                                   $silmeislem = $db->prepare("DELETE from urundetay_benzer_urun WHERE detay_id=:detay_id");
                                   $sil = $silmeislem->execute(array(
                                       'detay_id' => $row['id']
                                   ));
                                   /*  <========SON=========>>> Detay Benzer Ürünler Sil SON */

                                   /* Favorilerden Sil */
                                   $silmeislem = $db->prepare("DELETE from urun_favori WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   /*  <========SON=========>>> Favorilerden Sil SON */
                                     /* galeri sil */
                                   $galeriListesi = $db->prepare("select * from urun_galeri where urun_id=:urun_id ");
                                   $galeriListesi->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   if($galeriListesi->rowCount()>'0'  ) {
                                       foreach ($galeriListesi as $galerisil){
                                           unlink('../images/product/'.$galerisil['gorsel'].'');
                                           $silmeislem = $db->prepare("DELETE from urun_galeri WHERE urun_id=:urun_id");
                                           $sil = $silmeislem->execute(array(
                                               'urun_id' => $row['id']
                                           ));
                                       }
                                   }
                                   /*  <========SON=========>>> galeri sil SON */

                                                                      /* Yorum Sil */
                                   $silmeislem = $db->prepare("DELETE from urun_yorum WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   /*  <========SON=========>>> Yorum Sil SON */

                                   /* Teknik Özellik Sil */
                                   $silmeislem = $db->prepare("DELETE from filtre_ozellik WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   $silmeislem = $db->prepare("DELETE from filtre_ozellik_grup WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   /*  <========SON=========>>> Teknik Özellik Sil SON */

                                   /* Vitrinlerden Sil */
                                   $silmeislem = $db->prepare("DELETE from vitrin_firsat_urunler WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   $silmeislem = $db->prepare("DELETE from vitrin_tip1_urunler WHERE urun_id=:urun_id");
                                   $sil = $silmeislem->execute(array(
                                       'urun_id' => $row['id']
                                   ));
                                   /*  <========SON=========>>> Vitrinlerden Sil SON */

                                   $silmeislem = $db->prepare("DELETE from urun WHERE id=:id");
                                   $sil = $silmeislem->execute(array(
                                       'id' => $row['id']
                                   ));
                                   if($row['gorsel'] == !null && $row['gorsel'] != 'no-img.jpg' ) {
                                       unlink('../images/product/'.$row['gorsel'].'');
                                       unlink('../images/product/big_photo/'.$row['gorsel'].'');
                                   }

                               }
                           }
                           $_SESSION['main_alert'] ='success';
                           header('Location:'.$ayar['panel_url'].'pages.php?page=products');
                       }
                   }else{
                       $_SESSION['main_alert'] ='nocheck';
                       header('Location:'.$ayar['panel_url'].'pages.php?page=products');
                   }

            }

            if($_GET['status'] == 'product_delete'  ) {
                if(isset($_GET['no']) && $_GET['no']>'0'  ) {
                    productControl($_GET['no']);
                    if ($Sql->rowCount() > '0' ) {

                        /* varyantlar silinsin */
                        $silmeislem = $db->prepare("DELETE from detay_varyant WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                        'urun_id' => $_GET['no']
                        ));
                        $silmeislem = $db->prepare("DELETE from detay_varyant_ozellik WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                        ));
                        $silmeislem = $db->prepare("DELETE from urun_varyant_ekler WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                        ));
                        /*  <========SON=========>>> varyantlar silinsin SON */

                        /* Detay Benzer Ürünler Sil */
                        $silmeislem = $db->prepare("DELETE from urundetay_benzer_urun WHERE detay_id=:detay_id");
                        $sil = $silmeislem->execute(array(
                            'detay_id' => $_GET['no']
                        ));
                        /*  <========SON=========>>> Detay Benzer Ürünler Sil SON */

                        /* Favorilerden Sil */
                        $silmeislem = $db->prepare("DELETE from urun_favori WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                        ));
                        /*  <========SON=========>>> Favorilerden Sil SON */

                        /* galeri sil */
                       $galeriListesi = $db->prepare("select * from urun_galeri where urun_id=:urun_id ");
                       $galeriListesi->execute(array(
                           'urun_id' => $_GET['no']
                       ));
                       if($galeriListesi->rowCount()>'0'  ) {
                        foreach ($galeriListesi as $galerisil){
                            unlink('../images/product/'.$galerisil['gorsel'].'');
                            $silmeislem = $db->prepare("DELETE from urun_galeri WHERE urun_id=:urun_id");
                            $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                            ));
                        }
                       }
                        /*  <========SON=========>>> galeri sil SON */

                        /* Yorum Sil */
                        $silmeislem = $db->prepare("DELETE from urun_yorum WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                        ));
                        /*  <========SON=========>>> Yorum Sil SON */

                        /* Teknik Özellik Sil */
                        $silmeislem = $db->prepare("DELETE from filtre_ozellik WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                        ));
                        $silmeislem = $db->prepare("DELETE from filtre_ozellik_grup WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                        ));
                        /*  <========SON=========>>> Teknik Özellik Sil SON */

                        /* Vitrinlerden Sil */
                        $silmeislem = $db->prepare("DELETE from vitrin_firsat_urunler WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                        ));
                        $silmeislem = $db->prepare("DELETE from vitrin_tip1_urunler WHERE urun_id=:urun_id");
                        $sil = $silmeislem->execute(array(
                            'urun_id' => $_GET['no']
                        ));
                        /*  <========SON=========>>> Vitrinlerden Sil SON */

                        $silmeislem = $db->prepare("DELETE from urun WHERE id=:id");
                        $sil = $silmeislem->execute(array(
                            'id' => $_GET['no']
                        ));
                        if($sil  ) {
                            if($row['gorsel'] == !null && $row['gorsel'] != 'no-img.jpg' ) {
                                unlink('../images/product/'.$row['gorsel'].'');
                                unlink('../images/product/big_photo/'.$row['gorsel'].'');
                            }
                            header('Location:'.$ayar['panel_url'].'pages.php?page=products&status=newproductgo');
                            $_SESSION['main_alert'] = 'success';
                        }


                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }
            }






            if($_GET['status'] == 'product_add'  ) {
                if ($_POST && isset($_POST['insert'])) {
                    if($_POST['durum'] == '1' || $_POST['durum'] == '0'  ) {
                        if($_POST['gorunmez']=='0' || $_POST['gorunmez'] == '1'  ) {
                            if($_POST['baslik']  && $_POST['stok']  ) {
                                
                                
                                $urunKutuAyar = $db->prepare("select resim_w,resim_h,resim_big_w,resim_big_h from urun_kutu where id='1' ");
                                $urunKutuAyar->execute();
                                $urunboxRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
                                $resim_w = $urunboxRow['resim_w'];
                                $resim_h = $urunboxRow['resim_h'];
                                $resim_big_w = $urunboxRow['resim_big_w'];
                                $resim_big_h = $urunboxRow['resim_big_h'];


                                /* Stok kodu yoksa üret */
                                if($_POST['urun_kod'] == !null  ) {
                                 $stok_kod = $_POST['urun_kod'];
                                }else{

                                    function get_random_string($length = 7, $characters = "ABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789")
                                    {

                                        $return = "";
                                        $num_characters = strlen($characters) - 1;
                                        while (strlen($return) < $length) {
                                            $return .= $characters[mt_rand(0, $num_characters)];
                                        }
                                        return $return;
                                    }

                                    $stok_kod = get_random_string();

                                }
                                /*  <========SON=========>>> Stok kodu yoksa üret SON */

                                /* Seo url yoksa Üret */
                                if($_POST['seo_url']== !null  ) {
                                    $seo_url = $_POST['seo_url'];
                                }else{
                                    $seo_url = seo($_POST['baslik']);
                                }
                                /*  <========SON=========>>> Seo url yoksa Üret SON */

                                $sadetarih = date('Y-m-d');
                                $tarih = date('Y-m-d G:i:s');
                                $ekleyen = $adminRow['user_adi'];

                                if ($_FILES['gorsel']["size"] > 0) {
                                    $file_format = $_FILES["gorsel"];
                                    if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                        /* Görsel Upload */
                                        include_once('inc/class.upload.php');
                                        $upload = new Upload($_FILES['gorsel']);
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
                                            $file_name = $upload->file_dst_name;
                                        }else{
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=products');
                                            $_SESSION['main_alert'] = 'filetype';
                                            exit();
                                        }
                                        /*  <========SON=========>>> Görsel Upload SON */

                                        $kaydet = $db->prepare("INSERT INTO urun SET
                                             baslik=:baslik,    
                                             ekleyen=:ekleyen,
                                             sade_tarih=:sade_tarih,   
                                             fiyat=:fiyat,
                                             eski_fiyat=:eski_fiyat,
                                             alis_fiyat=:alis_fiyat,
                                             fiyat_tip2=:fiyat_tip2,
                                             havale_indirim_tutar=:havale_indirim_tutar,
                                             kargo_ucret=:kargo_ucret,
                                             marka=:marka, 
                                             tarih=:tarih, 
                                             fiyat_goster=:fiyat_goster,
                                             seo_url=:seo_url,
                                             seo_baslik=:seo_baslik,
                                             gorsel=:gorsel,
                                             stok=:stok,
                                             urun_kod=:urun_kod,
                                             durum=:durum,
                                             dil=:dil,
                                             gorunmez=:gorunmez
                                          ");
                                        $sonuc = $kaydet->execute(array(
                                            'baslik' => $_POST['baslik'],
                                            'ekleyen' => $ekleyen,
                                            'sade_tarih' => $sadetarih,
                                            'fiyat' => '0',
                                            'eski_fiyat' => '0',
                                            'alis_fiyat' => '0',
                                            'fiyat_tip2' => '0',
                                            'havale_indirim_tutar' => '0',
                                            'kargo_ucret' => '0',
                                            'marka' => null,
                                            'tarih' => $tarih,
                                            'fiyat_goster' => '1',
                                            'seo_url' => $seo_url,
                                            'seo_baslik' => $_POST['baslik'],
                                            'gorsel' => $file_name,
                                            'stok' => $_POST['stok'],
                                            'urun_kod' => $stok_kod,
                                            'durum' => $_POST['durum'],
                                            'dil' => $_SESSION['dil'],
                                            'gorunmez' => $_POST['gorunmez']
                                        ));
                                        if($sonuc){
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=products&status=newproductgo');
                                            $_SESSION['main_alert'] = 'success_product';
                                        }else{
                                            echo 'Veritabanı Hatası';
                                        }

                                    }else{
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=products');
                                        $_SESSION['collepse_status'] = 'genelAcc';
                                        $_SESSION['main_alert'] = 'filetype';
                                    }
                                }else{
                                    /* fotosuz */
                                  $kaydet = $db->prepare("INSERT INTO urun SET
                                     baslik=:baslik,  
                                     ekleyen=:ekleyen,
                                     sade_tarih=:sade_tarih,   
                                     tarih=:tarih,
                                     seo_url=:seo_url,
                                     seo_baslik=:seo_baslik,
                                     gorsel=:gorsel,
                                     stok=:stok,
                                     urun_kod=:urun_kod,
                                     durum=:durum,
                                     dil=:dil,
                                     gorunmez=:gorunmez
                                  ");
                                  $sonuc = $kaydet->execute(array(
                                    'baslik' => $_POST['baslik'],
                                      'ekleyen' => $ekleyen,
                                      'sade_tarih' => $sadetarih,
                                      'tarih' => $tarih,
                                      'seo_url' => $seo_url,
                                      'seo_baslik' => $_POST['baslik'],
                                      'gorsel' => 'no-img.jpg',
                                      'stok' => $_POST['stok'],
                                      'urun_kod' => $stok_kod,
                                      'durum' => $_POST['durum'],
                                      'dil' => $_SESSION['dil'],
                                      'gorunmez' => $_POST['gorunmez']
                                  ));
                                  if($sonuc){
                                      header('Location:'.$ayar['panel_url'].'pages.php?page=products&status=newproductgo');
                                      $_SESSION['main_alert'] = 'success_product';
                                  }else{
                                  echo 'Veritabanı Hatası';
                                  }
                                    /*  <========SON=========>>> fotosuz SON */
                                }

                            }else{
                                $_SESSION['main_alert'] = 'zorunlu';
                                header('Location:'.$ayar['panel_url'].'pages.php?page=products');
                            }
                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'product_gallery'  ) {
                $folder_name = '../images/product/';
                $random = rand(0, (int)99999);
                $random2 = rand(0, (int)999);
                $filename =  trim(addslashes($_FILES['file']['name']));
                $filename = str_replace(' ', '_', $filename);
                $filename = str_replace('ş', 's', $filename);
                $filename = str_replace('&', '-', $filename);
                $filename = str_replace('%', '-', $filename);
                $filename = str_replace('?', '-', $filename);
                $filename = str_replace('+', '-', $filename);
                $filename = str_replace('ı', 'i', $filename);
                $filename = str_replace('Ş', 's', $filename);
                $filename = str_replace('ğ', 'g', $filename);
                $filename = str_replace('Ğ', 'g', $filename);
                $filename = str_replace('ü', 'u', $filename);
                $filename = str_replace('Ü', 'u', $filename);
                $filename = str_replace('ç', 'c', $filename);
                $filename = str_replace('Ç', 'c', $filename);
                $filename = str_replace('ö', 'o', $filename);
                $filename = str_replace('Ö', 'o', $filename);
                $filename = str_replace('İ', 'i', $filename);
                $filename = preg_replace('/\s+/', '_', $filename);
                $file_name = $random . "-" . $random2 . "-" . $filename;
                $temp_file = $_FILES['file']['tmp_name'];

                move_uploaded_file($temp_file, $folder_name.$file_name);

                $kaydet = $db->prepare("INSERT INTO urun_galeri SET
                      gorsel=:gorsel,
                      urun_id=:urun_id
                      ");
                $ekle = $kaydet->execute(array(
                    'gorsel' => $file_name,
                    'urun_id' => $_GET['productID']
                ));
            }

            if($_GET['status'] == 'product_post'  ) {

                if(isset($_POST['tab'])) {
                    if($_POST['tab'] == 'product_info' || $_POST['tab'] == 'product_price' || $_POST['tab'] == 'variant_stock_add' || $_POST['tab'] == 'variant_stock_edit' || $_POST['tab'] == 'description' || $_POST['tab'] == 'variant' || $_POST['tab'] == 'variant_edit' || $_POST['tab'] == 'features'  || $_POST['tab'] == 'extra' || $_POST['tab'] == 'meta' || $_POST['tab'] == 'other' ) {
                        if($_POST['product_id']  ) {


                            /* varyant stok edit */
                            if($_POST['tab'] == 'variant_stock_edit' && isset($_POST['stockEdit'])  ) {
                                if($_POST['stok_kodu'] && $_POST['stock_id']  ) {

                                    $guncelle = $db->prepare("UPDATE detay_varyant_stok SET
                                            stok_kodu=:stok_kodu,
                                            stok=:stok
                                     WHERE id={$_POST['stock_id']}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'stok_kodu' => $_POST['stok_kodu'],
                                        'stok' => $_POST['stok']
                                    ));
                                    if($sonuc){
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                        $_SESSION['main_alert'] = 'success';
                                        $_SESSION['collepse_status'] = 'stokAcc';
                                    }else{
                                    echo 'Veritabanı Hatası';
                                    }

                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> varyant stok edit SON */

                            /* Varyant Stok Ekle */
                            if($_POST['tab'] == 'variant_stock_add' && isset($_POST['stockAdd'])  ) {

                                if($_POST['gruplar'] && $_POST['stok_adet'] && $_POST['stok_name']  ) {


                                   foreach ( $_POST['gruplar'] as $var){
                                       if($var !=''  ) {
                                           $varyantlar .= ''.$var.',';
                                       }
                                   }
                                   $varyantKontrol = $db->prepare("select * from detay_varyant_stok where varyant=:varyant ");
                                   $varyantKontrol->execute(array(
                                       'varyant' => $varyantlar,
                                   ));
                                   if($varyantKontrol->rowCount()>'0'  ) {
                                       header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                       $_SESSION['main_alert'] = 'varyant_stok_var';
                                       $_SESSION['collepse_status'] = 'stokAcc';
                                       exit();
                                   }

                                   $kaydet = $db->prepare("INSERT INTO detay_varyant_stok SET
                                          varyant=:varyant, 
                                          urun_id=:urun_id,
                                          stok=:stok,
                                          stok_kodu=:stok_kodu
                                   ");
                                   $sonuc = $kaydet->execute(array(
                                       'varyant' => $varyantlar,
                                       'urun_id' => $_POST['product_id'],
                                       'stok' => $_POST['stok_adet'],
                                       'stok_kodu' => $_POST['stok_name'],
                                   ));
                                    if($sonuc){
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                        $_SESSION['main_alert'] = 'success';
                                        $_SESSION['collepse_status'] = 'stokAcc';
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> Varyant Stok Ekle SON */


                            /* variant edit */
                            if($_POST['tab'] == 'variant_edit' && isset($_POST['variantID_update'])  ) {

                                if($_POST['variant_id'] && $_POST['group_id'] && $_POST['grup_tur'] ) {

                                    /* Varyant Grubu Update */
                                    if($_POST['grup_tur'] == '2'  ) {
                                        $guncelle = $db->prepare("UPDATE detay_varyant SET
                                                zorunlu=:zorunlu
                                         WHERE id={$_POST['group_id']}      
                                        ");
                                        $sonuc = $guncelle->execute(array(
                                            'zorunlu' => $_POST['zorunlu'],
                                        ));
                                    }
                                    if($_POST['grup_tur'] == '4'  ) {
                                        $guncelle = $db->prepare("UPDATE detay_varyant SET
                                                zorunlu=:zorunlu
                                         WHERE id={$_POST['group_id']}      
                                        ");
                                        $sonuc = $guncelle->execute(array(
                                            'zorunlu' => $_POST['zorunlu'],
                                        ));
                                    }
                                    /*  <========SON=========>>> Varyant Grubu Update SON */

                                    /* vrayant görseli varsa ekle */
                                    if($_POST['grup_tur'] == '3'  ) {
                                        $old_img = $_POST['old_img'];
                                        if ($_FILES['gorsel']["size"] > 0) {
                                            $file_format = $_FILES["gorsel"];
                                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                                /* Görsel Upload */
                                                include_once('inc/class.upload.php');
                                                $upload = new Upload($_FILES['gorsel']);
                                                if ($upload->uploaded) {
                                                    $random = rand(0, (int)99991234569);
                                                    $random2 = rand(0, (int)999);
                                                    $upload->file_name_body_pre = 'variant_';
                                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                                    $upload->image_resize = true;
                                                    $upload->png_quality = 90;
                                                    $upload->webp_quality = 92;
                                                    $upload->jpeg_quality = 92;
                                                    $upload->png_compression = 9;
                                                    if($_POST['gorsel_w'] == !null && $_POST['gorsel_h']==!null  ) {
                                                        $upload->image_x = $_POST['gorsel_w'];
                                                        $upload->image_y = $_POST['gorsel_h'];
                                                    }else{
                                                        $upload->image_x = 50;
                                                        $upload->image_y = 50;
                                                    }
                                                    $upload->process("../i/variants");
                                                }
                                                if ($upload->processed){
                                                    $file_name = $upload->file_dst_name;
                                                    unlink('../i/variants/'.$old_img.'');
                                                }else{
                                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                                    $_SESSION['main_alert'] = 'filetype';
                                                    exit();
                                                }
                                                /*  <========SON=========>>> Görsel Upload SON */
                                                $gorsel = $file_name;
                                            }else{
                                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                                $_SESSION['main_alert'] = 'filetype';
                                                exit();
                                            }
                                        }else{
                                            $gorsel = $old_img;
                                        }
                                    }else{
                                        $gorsel = null;
                                    }
                                    /*  <========SON=========>>> vrayant görseli varsa ekle SON */

                                    if($_POST['ek_fiyat'] == !null  ) {
                                     $ekfiyat = $_POST['ek_fiyat'];
                                    }else{
                                        $ekfiyat = '0';
                                    }

                                    $guncelle = $db->prepare("UPDATE detay_varyant_ozellik SET
                                            ek_fiyat=:ek_fiyat,
                                            fiyat_goster=:fiyat_goster,
                                            gorsel=:gorsel,
                                            disable=:disable,
                                            disable_t=:disable_t,
                                            tarih_bugun=:tarih_bugun,
                                            tarih_yil=:tarih_yil,
                                            gorsel_w=:gorsel_w,
                                            gorsel_h=:gorsel_h
                                     WHERE id={$_POST['variant_id']}      
                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'ek_fiyat' => $ekfiyat,
                                        'fiyat_goster' => $_POST['fiyat_goster'],
                                        'gorsel' => $gorsel,
                                        'disable' => $_POST['disable'],
                                        'disable_t' => $_POST['disable_t'],
                                        'tarih_bugun' => $_POST['tarih_bugun'],
                                        'tarih_yil' => $_POST['tarih_yil'],
                                        'gorsel_w' => $_POST['gorsel_w'],
                                        'gorsel_h' => $_POST['gorsel_h']
                                    ));
                                    if($sonuc){
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                    echo 'Veritabanı Hatası';
                                    }


                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }

                            }
                            /*  <========SON=========>>> variant edit SON */

                            /* Varyant Ekle */
                            if($_POST['tab'] == 'variant' && isset($_POST['variant_add'])  ) {

                                productControl($_POST['product_id']);
                                if ($Sql->rowCount() > '0' && $_POST['varyant_grup'] == !null && $_POST['variant_id']) {

                                    if($_POST['ekli_tur']== '2'  ) {
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                        $_SESSION['main_alert'] = 'variant_tur_2';
                                        exit();
                                    }

                                    if($_POST['tur'] == '1' || $_POST['tur'] == '2' || $_POST['tur'] == '3' || $_POST['tur'] == '4' ) {

                                        $VariantSql = $db->prepare("select * from urun_varyant where id=:id ");
                                        $VariantSql->execute(array(
                                            'id' => $_POST['varyant_grup'],
                                        ));
                                        $varsqlRow = $VariantSql->fetch(PDO::FETCH_ASSOC);
                                        if($VariantSql->rowCount()>'0'  ) {

                                            $varmikontrol = $db->prepare("select * from detay_varyant where urun_id=:urun_id and varyant_id=:varyant_id ");
                                            $varmikontrol->execute(array(
                                                'urun_id' => $_POST['product_id'],
                                                'varyant_id' => $_POST['varyant_grup'],
                                            ));

                                            if($varmikontrol->rowCount()<='0'  ) {
                                             /* Eklenmemiş. Sıfırdan ekle */
                                                /* Görsel var ise buradan işlemler yapılsın */
                                                if($_POST['tur'] == '3'  ) {
                                                    if ($_FILES['gorsel']["size"] > 0) {
                                                        $file_format = $_FILES["gorsel"];
                                                        if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                                            /* Görsel Upload */
                                                            include_once('inc/class.upload.php');
                                                            $upload = new Upload($_FILES['gorsel']);
                                                            if ($upload->uploaded) {
                                                                $random = rand(0, (int)99991234569);
                                                                $random2 = rand(0, (int)999);
                                                                $upload->file_name_body_pre = 'variant_';
                                                                $upload->file_name_body_add = ''.$random.''.$random2.'';
                                                                $upload->image_resize = true;
                                                                $upload->png_quality = 90;
                                                                $upload->webp_quality = 92;
                                                                $upload->jpeg_quality = 92;
                                                                $upload->png_compression = 9;
                                                                if($_POST['gorsel_w'] == !null && $_POST['gorsel_h']==!null  ) {
                                                                    $upload->image_x = $_POST['gorsel_w'];
                                                                    $upload->image_y = $_POST['gorsel_h'];
                                                                }else{
                                                                    $upload->image_x = 50;
                                                                    $upload->image_y = 50;
                                                                }
                                                                $upload->process("../i/variants");
                                                            }
                                                            if ($upload->processed){
                                                                $file_name = $upload->file_dst_name;
                                                            }else{
                                                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                                                $_SESSION['main_alert'] = 'filetype';
                                                                exit();
                                                            }
                                                            /*  <========SON=========>>> Görsel Upload SON */
                                                            $gorsel = $file_name;
                                                        }else{
                                                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                                            $_SESSION['main_alert'] = 'filetype';
                                                            exit();
                                                        }
                                                    }else{
                                                        $gorsel = null;
                                                    }
                                                }else{
                                                    $gorsel = null;
                                                }

                                                if($_POST['tur'] == '4'  ) {
                                                 $zorunluDurum = $_POST['zorunlu_tur4'];
                                                }else{
                                                    $zorunluDurum = $_POST['zorunlu'];
                                                }
                                                /*  <========SON=========>>> Görsel var ise buradan işlemler yapılsın SON */

                                                /* Detay Varyant Grubu Ekle */
                                                $kaydet = $db->prepare("INSERT INTO detay_varyant SET
                                                    baslik=:baslik,
                                                    urun_id=:urun_id,
                                                    varyant_id=:varyant_id,
                                                    sira=:sira,
                                                    tur=:tur,
                                                    zorunlu=:zorunlu
                                            ");
                                                $sonuc = $kaydet->execute(array(
                                                    'baslik' => $varsqlRow['baslik'],
                                                    'urun_id' => $_POST['product_id'],
                                                    'varyant_id' => $_POST['varyant_grup'],
                                                    'sira' => $varsqlRow['sira'],
                                                    'tur' => $_POST['tur'],
                                                    'zorunlu' => $zorunluDurum
                                                ));
                                                /*  <========SON=========>>> Detay Varyant Grubu Ekle SON */

                                                /* Varyant Değeri ekle */
                                                $degerSql = $db->prepare("select * from urun_varyant_ozellik where id=:id ");
                                                $degerSql->execute(array(
                                                    'id' => $_POST['variant_id'],
                                                ));
                                                $ozRow = $degerSql->fetch(PDO::FETCH_ASSOC);
                                                if($_POST['ek_fiyat'] == !null  ) {
                                                    $ekfiyat = $_POST['ek_fiyat'];
                                                }else{
                                                    $ekfiyat = '0';
                                                }
                                                $kaydet = $db->prepare("INSERT INTO detay_varyant_ozellik SET
                                                        baslik=:baslik,
                                                        ozellik_id=:ozellik_id,
                                                        urun_id=:urun_id,
                                                        varyant_id=:varyant_id,
                                                        ek_fiyat=:ek_fiyat,
                                                        fiyat_goster=:fiyat_goster,
                                                        tarih_bugun=:tarih_bugun,
                                                        tarih_yil=:tarih_yil,
                                                        gorsel=:gorsel,
                                                        gorsel_w=:gorsel_w,
                                                        gorsel_h=:gorsel_h
                                                ");
                                                $sonuc = $kaydet->execute(array(
                                                    'baslik' => $ozRow['baslik'],
                                                    'ozellik_id' => $_POST['variant_id'],
                                                    'urun_id' => $_POST['product_id'],
                                                    'varyant_id' => $_POST['varyant_grup'],
                                                    'ek_fiyat' => $ekfiyat,
                                                    'fiyat_goster' => $_POST['fiyat_goster'],
                                                    'tarih_bugun' => $_POST['tarih_bugun'],
                                                    'tarih_yil' => $_POST['tarih_yil'],
                                                    'gorsel' => $gorsel,
                                                    'gorsel_w' => $_POST['gorsel_w'],
                                                    'gorsel_h' => $_POST['gorsel_h'],
                                                ));
                                                if($sonuc){
                                                    $_SESSION['collepse_status'] = 'go_scroll' ;
                                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                                }else{
                                                echo 'Veritabanı Hatası';
                                                }
                                                /*  <========SON=========>>> Varyant Değeri ekle SON */



                                             /*  <========SON=========>>> Eklenmemiş. Sıfırdan ekle SON */
                                            }else{
                                                /* Daha Önce Bu Eklenmiş!! Aynı varyant değeri mi onu bul! */
                                                $degerVarmiKontrol = $db->prepare("select * from detay_varyant_ozellik where urun_id=:urun_id and ozellik_id=:ozellik_id ");
                                                $degerVarmiKontrol->execute(array(
                                                    'urun_id' => $_POST['product_id'],
                                                    'ozellik_id' => $_POST['variant_id'],
                                                ));

                                                if($degerVarmiKontrol->rowCount()<='0'  ) {
                                                    /* Bu varyant grubuna yeni değer eklenebilir */
                                                    /* Görsel var ise buradan işlemler yapılsın */
                                                    if($_POST['tur'] == '3'  ) {
                                                        if ($_FILES['gorsel']["size"] > 0) {
                                                            $file_format = $_FILES["gorsel"];
                                                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                                                /* Görsel Upload */
                                                                include_once('inc/class.upload.php');
                                                                $upload = new Upload($_FILES['gorsel']);
                                                                if ($upload->uploaded) {
                                                                    $random = rand(0, (int)99991234569);
                                                                    $random2 = rand(0, (int)999);
                                                                    $upload->file_name_body_pre = 'variant_';
                                                                    $upload->file_name_body_add = ''.$random.''.$random2.'';
                                                                    $upload->image_resize = true;
                                                                    $upload->png_quality = 90;
                                                                    $upload->webp_quality = 92;
                                                                    $upload->jpeg_quality = 92;
                                                                    $upload->png_compression = 9;
                                                                    if($_POST['gorsel_w'] == !null && $_POST['gorsel_h']==!null  ) {
                                                                        $upload->image_x = $_POST['gorsel_w'];
                                                                        $upload->image_y = $_POST['gorsel_h'];
                                                                    }else{
                                                                        $upload->image_x = 50;
                                                                        $upload->image_y = 50;
                                                                    }
                                                                    $upload->process("../i/variants");
                                                                }
                                                                if ($upload->processed){
                                                                    $file_name = $upload->file_dst_name;
                                                                }else{
                                                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                                                    $_SESSION['main_alert'] = 'filetype';
                                                                    exit();
                                                                }
                                                                /*  <========SON=========>>> Görsel Upload SON */
                                                                $gorsel = $file_name;
                                                            }else{
                                                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                                                $_SESSION['main_alert'] = 'filetype';
                                                                exit();
                                                            }
                                                        }else{
                                                            $gorsel = null;
                                                        }
                                                    }else{
                                                        $gorsel = null;
                                                    }
                                                    /*  <========SON=========>>> Görsel var ise buradan işlemler yapılsın SON */
                                                   if($_POST['tur'] == '2'  ) {
                                                       echo "Bu varyant grubuna Yazı alanı varyant değeri sadece tek sefer eklenebilir. Yeni yazı alanları için lütfen varyant ekleme merkezinden yeni varyant ve değer oluşturup ekleme yapınız";
                                                       echo "<br>";
                                                   }else{

                                                       echo "bu varyant değeri mevcut varyant içine eklenebilir";
                                                       /* Görsel var ise buradan işlemler yapılsın */
                                                       if($_POST['tur'] == '3'  ) {

                                                       }else{
                                                           $gorsel = null;
                                                       }
                                                       /*  <========SON=========>>> Görsel var ise buradan işlemler yapılsın SON */
                                                       $degerSql = $db->prepare("select * from urun_varyant_ozellik where id=:id ");
                                                       $degerSql->execute(array(
                                                           'id' => $_POST['variant_id'],
                                                       ));
                                                       $ozRow = $degerSql->fetch(PDO::FETCH_ASSOC);
                                                       if($_POST['ek_fiyat'] == !null  ) {
                                                           $ekfiyat = $_POST['ek_fiyat'];
                                                       }else{
                                                           $ekfiyat = '0';
                                                       }
                                                       $kaydet = $db->prepare("INSERT INTO detay_varyant_ozellik SET
                                                        baslik=:baslik,
                                                        ozellik_id=:ozellik_id,
                                                        urun_id=:urun_id,
                                                        varyant_id=:varyant_id,
                                                        ek_fiyat=:ek_fiyat,
                                                        fiyat_goster=:fiyat_goster,
                                                        gorsel=:gorsel,
                                                        gorsel_w=:gorsel_w,
                                                        gorsel_h=:gorsel_h
                                                ");
                                                       $sonuc = $kaydet->execute(array(
                                                           'baslik' => $ozRow['baslik'],
                                                           'ozellik_id' => $_POST['variant_id'],
                                                           'urun_id' => $_POST['product_id'],
                                                           'varyant_id' => $_POST['varyant_grup'],
                                                           'ek_fiyat' => $ekfiyat,
                                                           'fiyat_goster' => $_POST['fiyat_goster'],
                                                           'gorsel' => $gorsel,
                                                           'gorsel_w' => $_POST['gorsel_w'],
                                                           'gorsel_h' => $_POST['gorsel_h'],
                                                       ));
                                                       if($sonuc){
                                                           $_SESSION['collepse_status'] = 'go_scroll' ;
                                                           header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');
                                                       }else{
                                                           echo 'Veritabanı Hatası';
                                                       }

                                                   }


                                                    /*  <========SON=========>>> Bu varyant grubuna yeni değer eklenebilir SON */
                                                }else{

                                                    $_SESSION['main_alert'] = 'varyant_var' ;
                                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_variant&productID='.$_POST['product_id'].'');

                                                }
                                                /*  <========SON=========>>> Daha Önce Bu Eklenmiş!! Aynı varyant değeri mi onu bul! SON */
                                            }

                                        }else{
                                            header('Location:'.$ayar['site_url'].'404');
                                        }
                                    }else{
                                        header('Location:'.$ayar['site_url'].'404');
                                    }

                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> Varyant Ekle SON */

                            /* Ürün Özellikleri */
                            if($_POST['tab'] == 'features' && isset($_POST['features_add'])  ) {
                                productControl($_POST['product_id']);
                                if($Sql->rowCount()>'0' && $_POST['categories_id'] == !null && $_POST['kontrol'] && $_POST['feature_id'] ) {

                                    $kategoriler = $_POST['categories_id'];
                                    $grup_id = $_POST['kontrol'];
                                    $kontrol = $_POST['kontrol'];
                                    $ozellikID = $_POST['feature_id'];
                                    $ozellikRandomID = rand(0,(int) 9999999);
                                    $random = rand(0,(int) 9999999);

                                    $filtreGrubuVarmi = $db->prepare("select * from filtre_ozellik_grup where urun_id=:urun_id and kontrol=:kontrol ");
                                    $filtreGrubuVarmi->execute(array(
                                        'urun_id' => $_POST['product_id'],
                                        'kontrol' => $kontrol,
                                    ));

                                    if($filtreGrubuVarmi->rowCount()>'0'  ) {

                                        $filtreOzellikVarmi = $db->prepare("select * from filtre_ozellik where urun_id=:urun_id and ozellik_id=:ozellik_id ");
                                        $filtreOzellikVarmi->execute(array(
                                            'urun_id' => $_POST['product_id'],
                                            'ozellik_id' => $ozellikID,
                                        ));
                                        if($filtreOzellikVarmi->rowCount()<='0'  ) {
                                            /* Gerçek Gruptan Veri Çek */
                                            $RealGroup = $db->prepare("select * from urun_ozellik_grup where id=:id ");
                                            $RealGroup->execute(array(
                                                'id' => $kontrol,
                                            ));
                                            $realGroupRow = $RealGroup->fetch(PDO::FETCH_ASSOC);
                                            /*  <========SON=========>>> Gerçek Gruptan Veri Çek SON */

                                            /* Gerçek Özellikten Veri Çek */
                                            $RealFeatures = $db->prepare("select * from urun_ozellik where id=:id ");
                                            $RealFeatures->execute(array(
                                                'id' => $ozellikID,
                                            ));
                                            $realFeatRow = $RealFeatures->fetch(PDO::FETCH_ASSOC);
                                            /*  <========SON=========>>> Gerçek Özellikten Veri Çek SON */

                                            /* Ürüne kayıt edilecek özellikler ID'leri */
                                            $urunOzellikKaydi = $ozellikID.',';
                                            $newFeaturesIDS  = $row['ozellikler'];
                                            $eski   = ''.$row['ozellikler'].'';
                                            $yeni   = ''.$urunOzellikKaydi.''.$row['ozellikler'].'';
                                            $newFeaturesIDS = str_replace($eski, $yeni, $newFeaturesIDS);

                                            if($row['ozellikler'] == !null ) {
                                                $featuresGoIDS = $newFeaturesIDS;
                                            }else{
                                                $featuresGoIDS = $urunOzellikKaydi;
                                            }

                                            $guncelle = $db->prepare("UPDATE urun SET
                                            ozellikler=:ozellikler
                                     WHERE id={$_POST['product_id']}      
                                    ");
                                            $sonuc = $guncelle->execute(array(
                                                'ozellikler' => $featuresGoIDS
                                            ));
                                            /*  <========SON=========>>> Ürüne kayıt edilecek özellikler ID'leri SON */

                                            $GrupAdi = $realGroupRow['baslik'];
                                            $GrupSira = $realGroupRow['sira'];
                                            $OzellikAdi = $realFeatRow['baslik'];
                                            $OzellikSira = $realFeatRow['sira'];


                                            /* Filtreye Özel İsim */
                                            if($_POST['kisa_baslik'] == !null  ) {
                                                $filtreAdi = $_POST['kisa_baslik'];
                                            } else{
                                                $filtreAdi = $OzellikAdi;
                                            }
                                            /*  <========SON=========>>> Filtreye Özel İsim SON */

                                            /* Grubu Oluştur */
                                            $kaydet = $db->prepare("INSERT INTO filtre_ozellik_grup SET
                                                urun_id=:urun_id,    
                                                baslik=:baslik,
                                                real_grup_id=:real_grup_id,
                                                kat_id=:kat_id,
                                                durum=:durum,
                                                dil=:dil,
                                                random=:random,
                                                sira=:sira,
                                                kontrol=:kontrol
                                    ");
                                            $sonuc = $kaydet->execute(array(
                                                'urun_id' => $_POST['product_id'],
                                                'baslik' => $GrupAdi,
                                                'real_grup_id' => $grup_id,
                                                'kat_id' => $kategoriler,
                                                'durum' => '1',
                                                'dil' => $_SESSION['dil'],
                                                'random' => $random,
                                                'sira' => $GrupSira,
                                                'kontrol' => $kontrol
                                            ));
                                            /*  <========SON=========>>> Grubu Oluştur SON */

                                            /* Özellikleri ve Filtreleri Oluştur */
                                            $kaydet = $db->prepare("INSERT INTO filtre_ozellik SET
                                                baslik=:baslik,
                                                kisa_baslik=:kisa_baslik,
                                                grup_id=:grup_id,
                                                ozellik_id=:ozellik_id,
                                                urun_id=:urun_id,
                                                sira=:sira,
                                                random=:random,
                                                kat_id=:kat_id,
                                                filtre=:filtre,
                                                kontrol=:kontrol
                                    ");
                                            $sonuc = $kaydet->execute(array(
                                                'baslik' => $OzellikAdi,
                                                'kisa_baslik' => $filtreAdi,
                                                'grup_id' => $grup_id,
                                                'ozellik_id' => $ozellikID,
                                                'urun_id' => $_POST['product_id'],
                                                'sira' => $OzellikSira,
                                                'random' => $random,
                                                'kat_id' => $kategoriler,
                                                'filtre' => $_POST['filtre'],
                                                'kontrol' => $kontrol
                                            ));
                                            /*  <========SON=========>>> Özellikleri ve Filtreleri Oluştur SON */

                                            $_SESSION['collepse_status'] = 'go_scroll' ;
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_POST['product_id'].'');



                                        }else{
                                            header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_POST['product_id'].'');
                                            $_SESSION['main_alert'] = 'filtreden_var';
                                        }

                                    }else{
                                        echo "Bu gruptan yok! Direkt ekleyebilirsin.";
                                        /* Gerçek Gruptan Veri Çek */
                                        $RealGroup = $db->prepare("select * from urun_ozellik_grup where id=:id ");
                                        $RealGroup->execute(array(
                                            'id' => $kontrol,
                                        ));
                                        $realGroupRow = $RealGroup->fetch(PDO::FETCH_ASSOC);
                                        /*  <========SON=========>>> Gerçek Gruptan Veri Çek SON */

                                        /* Gerçek Özellikten Veri Çek */
                                        $RealFeatures = $db->prepare("select * from urun_ozellik where id=:id ");
                                        $RealFeatures->execute(array(
                                            'id' => $ozellikID,
                                        ));
                                        $realFeatRow = $RealFeatures->fetch(PDO::FETCH_ASSOC);
                                        /*  <========SON=========>>> Gerçek Özellikten Veri Çek SON */

                                        /* Ürüne kayıt edilecek özellikler ID'leri */
                                        $urunOzellikKaydi = $ozellikID.',';
                                        $newFeaturesIDS  = $row['ozellikler'];
                                        $eski   = ''.$row['ozellikler'].'';
                                        $yeni   = ''.$urunOzellikKaydi.''.$row['ozellikler'].'';
                                        $newFeaturesIDS = str_replace($eski, $yeni, $newFeaturesIDS);

                                        if($row['ozellikler'] == !null ) {
                                            $featuresGoIDS = $newFeaturesIDS;
                                        }else{
                                            $featuresGoIDS = $urunOzellikKaydi;
                                        }

                                        $guncelle = $db->prepare("UPDATE urun SET
                                            ozellikler=:ozellikler
                                     WHERE id={$_POST['product_id']}      
                                    ");
                                        $sonuc = $guncelle->execute(array(
                                            'ozellikler' => $featuresGoIDS
                                        ));
                                        /*  <========SON=========>>> Ürüne kayıt edilecek özellikler ID'leri SON */

                                        $GrupAdi = $realGroupRow['baslik'];
                                        $GrupSira = $realGroupRow['sira'];
                                        $OzellikAdi = $realFeatRow['baslik'];
                                        $OzellikSira = $realFeatRow['sira'];


                                        /* Filtreye Özel İsim */
                                        if($_POST['kisa_baslik'] == !null  ) {
                                            $filtreAdi = $_POST['kisa_baslik'];
                                        } else{
                                            $filtreAdi = $OzellikAdi;
                                        }
                                        /*  <========SON=========>>> Filtreye Özel İsim SON */

                                        /* Grubu Oluştur */
                                        $kaydet = $db->prepare("INSERT INTO filtre_ozellik_grup SET
                                        urun_id=:urun_id,    
                                        baslik=:baslik,
                                        real_grup_id=:real_grup_id,
                                        kat_id=:kat_id,
                                        durum=:durum,
                                        dil=:dil,
                                        random=:random, 
                                        sira=:sira,
                                        kontrol=:kontrol
                                    ");
                                        $sonuc = $kaydet->execute(array(
                                            'urun_id' => $_POST['product_id'],
                                            'baslik' => $GrupAdi,
                                            'real_grup_id' => $grup_id,
                                            'kat_id' => $kategoriler,
                                            'durum' => '1',
                                            'dil' => $_SESSION['dil'],
                                            'random' => $random,
                                            'sira' => $GrupSira,
                                            'kontrol' => $kontrol
                                        ));
                                        /*  <========SON=========>>> Grubu Oluştur SON */

                                        /* Özellikleri ve Filtreleri Oluştur */
                                        $kaydet = $db->prepare("INSERT INTO filtre_ozellik SET
                                            baslik=:baslik,
                                            kisa_baslik=:kisa_baslik,
                                            grup_id=:grup_id,
                                            ozellik_id=:ozellik_id,
                                            urun_id=:urun_id,
                                            sira=:sira,
                                            random=:random,
                                            kat_id=:kat_id,
                                            filtre=:filtre,
                                            kontrol=:kontrol
                                    ");
                                        $sonuc = $kaydet->execute(array(
                                            'baslik' => $OzellikAdi,
                                            'kisa_baslik' => $filtreAdi,
                                            'grup_id' => $grup_id,
                                            'ozellik_id' => $ozellikID,
                                            'urun_id' => $_POST['product_id'],
                                            'sira' => $OzellikSira,
                                            'random' => $random,
                                            'kat_id' => $kategoriler,
                                            'filtre' => $_POST['filtre'],
                                            'kontrol' => $kontrol
                                        ));
                                        /*  <========SON=========>>> Özellikleri ve Filtreleri Oluştur SON */

                                        $_SESSION['collepse_status'] = 'go_scroll' ;
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail_features&productID='.$_POST['product_id'].'');
                                    }



                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> Ürün Özellikleri SON */


                        /* Ürün Bilgileri Sekmesi */
                            if($_POST['tab'] == 'product_info' && isset($_POST['info_update'])  ) {
                                productControl($_POST['product_id']);
                                if($Sql->rowCount()>'0'  ) {

                                    if($_POST['baslik'] && $_POST['iliskili_kat'] && $_POST['kat_id']  ) {


                                        $urunKutuAyar = $db->prepare("select resim_w,resim_h,resim_big_w,resim_big_h from urun_kutu where id='1' ");
                                        $urunKutuAyar->execute();
                                        $urunboxRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);
                                        $resim_w = $urunboxRow['resim_w'];
                                        $resim_h = $urunboxRow['resim_h'];
                                        $resim_big_w = $urunboxRow['resim_big_w'];
                                        $resim_big_h = $urunboxRow['resim_big_h'];


                                        /* Stok kodu yoksa üret */
                                        if($_POST['urun_kod'] == !null  ) {
                                            $stok_kod = $_POST['urun_kod'];
                                        }else{

                                            function get_random_string($length = 7, $characters = "ABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789")
                                            {

                                                $return = "";
                                                $num_characters = strlen($characters) - 1;
                                                while (strlen($return) < $length) {
                                                    $return .= $characters[mt_rand(0, $num_characters)];
                                                }
                                                return $return;
                                            }

                                            $stok_kod = get_random_string();

                                        }
                                        /*  <========SON=========>>> Stok kodu yoksa üret SON */

                                        /* Çoklu Kategori Listele */
                                        $categories = $_POST['kat_id'];

                                        foreach ($categories as $cats){
                                            $cates .= ''.$cats.',';
                                        }
                                        /*  <========SON=========>>> Çoklu Kategori Listele SON */

                                        /* Filtreler için kategori güncellemesi */
                                        if($row['kat_id'] != $cates ) {
                                            $guncelle = $db->prepare("UPDATE filtre_ozellik_grup SET
                                                    kat_id=:kat_id
                                             WHERE urun_id={$_POST['product_id']}      
                                            ");
                                            $guncelle->execute(array(
                                                'kat_id' => $cates
                                            ));
                                            $guncelle2 = $db->prepare("UPDATE filtre_ozellik SET
                                                    kat_id=:kat_id
                                             WHERE urun_id={$_POST['product_id']}      
                                            ");
                                            $guncelle2->execute(array(
                                                'kat_id' => $cates
                                            ));
                                        }
                                        /*  <========SON=========>>> Filtreler için kategori güncellemesi SON */

                                        /* marka */
                                        if($_POST['marka'] != '0'  ) {
                                            $markagetir = $_POST['marka'];
                                        }else{
                                            $markagetir = null;
                                        }
                                        /*  <========SON=========>>> marka SON */
                                        /* Markanın sırası */
                                        $markaSiraCek = $db->prepare("select sira from urun_marka where id=:id ");
                                        $markaSiraCek->execute(array(
                                            'id' => $_POST['marka'],
                                        ));
                                        $markaRow = $markaSiraCek->fetch(PDO::FETCH_ASSOC);
                                        $markasira = $markaRow['sira'];
                                        /*  <========SON=========>>> Markanın sırası SON */

                                        if ($_FILES['gorsel']["size"] > 0) {
                                            $file_format = $_FILES["gorsel"];
                                            if ($file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/jpg' ||  $file_format['type'] == 'image/png' || $file_format['type'] == 'image/webp' || $file_format['type'] == 'image/jxr' || $file_format['type'] == 'image/jp2' || $file_format['type'] == 'image/bmp' ) {
                                                /* Görsel Upload */
                                                include_once('inc/class.upload.php');
                                                $upload = new Upload($_FILES['gorsel']);
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
                                                    $upload->png_quality = 90;
                                                    $upload->webp_quality = 92;
                                                    $upload->jpeg_quality = 92;
                                                    $upload->png_compression = 9;
                                                    $upload->image_ratio_fill      = 'C';
                                                    $upload->image_x = $resim_w;
                                                    $upload->image_y = $resim_h;
                                                    $upload->image_background_color = '#FFF';
                                                    $upload->process("../images/product");
                                                }
                                                if ($upload->processed){
                                                    $file_name = $upload->file_dst_name;
                                                }else{
                                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail&productID='.$_POST['product_id'].'');
                                                    $_SESSION['main_alert'] = 'filetype';
                                                    exit();
                                                }
                                                /*  <========SON=========>>> Görsel Upload SON */
                                                $guncelle = $db->prepare("UPDATE urun SET
                                             baslik=:baslik,    
                                             gorsel=:gorsel,
                                             stok=:stok,
                                             urun_kod=:urun_kod,
                                             barkod=:barkod,
                                             kat_id=:kat_id,
                                             iliskili_kat=:iliskili_kat,
                                             siparis_islem=:siparis_islem,
                                             marka=:marka,
                                             marka_sira=:marka_sira,
                                             anasayfa=:anasayfa,
                                             firsat=:firsat,
                                             yeni=:yeni,
                                             editor_secim=:editor_secim,
                                             taksit=:taksit,
                                             yorum_durum=:yorum_durum,
                                             star_rate=:star_rate,
                                             durum=:durum,
                                             gorunmez=:gorunmez  
                                                 WHERE id={$_POST['product_id']}      
                                                ");
                                                $sonuc = $guncelle->execute(array(
                                                    'baslik' => $_POST['baslik'],
                                                    'gorsel' => $file_name,
                                                    'stok' => $_POST['stok'],
                                                    'urun_kod' => $stok_kod,
                                                    'barkod' => $_POST['barkod'],
                                                    'kat_id' => $cates,
                                                    'iliskili_kat' => $_POST['iliskili_kat'],
                                                    'siparis_islem' => $_POST['siparis_islem'],
                                                    'marka' => $markagetir,
                                                    'marka_sira' => $markasira,
                                                    'anasayfa' => $_POST['anasayfa'],
                                                    'firsat' => $_POST['firsat'],
                                                    'yeni' => $_POST['yeni'],
                                                    'editor_secim' => $_POST['editor_secim'],
                                                    'taksit' => $_POST['taksit'],
                                                    'yorum_durum' => $_POST['yorum_durum'],
                                                    'star_rate' => $_POST['star_rate'],
                                                    'durum' => $_POST['durum'],
                                                    'gorunmez' => $_POST['gorunmez']
                                                ));
                                                if($sonuc){
                                                    if($_POST['old_img'] == !null && $_POST['old_img'] !='no-img.jpg'  ) {
                                                     unlink('../images/product/'.$_POST['old_img'].'');
                                                        unlink('../images/product/big_photo/'.$_POST['old_img'].'');
                                                    }
                                                    header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail&productID='.$_POST['product_id'].'');
                                                    $_SESSION['main_alert'] = 'success';
                                                }else{
                                                    echo 'Veritabanı Hatası';
                                                }
                                            }else{
                                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail&productID='.$_POST['product_id'].'');
                                                $_SESSION['main_alert'] = 'filetype';
                                            }
                                        }else{
                                            /* fotosuz */
                                            $guncelle = $db->prepare("UPDATE urun SET
                                             baslik=:baslik,    
                                             stok=:stok,
                                             urun_kod=:urun_kod,
                                             barkod=:barkod,
                                             kat_id=:kat_id,
                                             iliskili_kat=:iliskili_kat,
                                             siparis_islem=:siparis_islem,
                                             marka=:marka,
                                             marka_sira=:marka_sira,
                                             anasayfa=:anasayfa,
                                             firsat=:firsat,
                                             yeni=:yeni,
                                             editor_secim=:editor_secim,
                                             taksit=:taksit,
                                             yorum_durum=:yorum_durum,
                                             star_rate=:star_rate,
                                             durum=:durum,
                                             gorunmez=:gorunmez  
                                                 WHERE id={$_POST['product_id']}      
                                                ");
                                            $sonuc = $guncelle->execute(array(
                                                'baslik' => $_POST['baslik'],
                                                'stok' => $_POST['stok'],
                                                'urun_kod' => $stok_kod,
                                                'barkod' => $_POST['barkod'],
                                                'kat_id' => $cates,
                                                'iliskili_kat' => $_POST['iliskili_kat'],
                                                'siparis_islem' => $_POST['siparis_islem'],
                                                'marka' => $_POST['marka'],
                                                'marka_sira' => $markasira,
                                                'anasayfa' => $_POST['anasayfa'],
                                                'firsat' => $_POST['firsat'],
                                                'yeni' => $_POST['yeni'],
                                                'editor_secim' => $_POST['editor_secim'],
                                                'taksit' => $_POST['taksit'],
                                                'yorum_durum' => $_POST['yorum_durum'],
                                                'star_rate' => $_POST['star_rate'],
                                                'durum' => $_POST['durum'],
                                                'gorunmez' => $_POST['gorunmez']
                                            ));
                                            if($sonuc){
                                                header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail&productID='.$_POST['product_id'].'');
                                                $_SESSION['main_alert'] = 'success';
                                            }else{
                                                echo 'Veritabanı Hatası';
                                            }
                                            /*  <========SON=========>>> fotosuz SON */
                                        }



                                    }else{
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=product_detail&productID='.$_POST['product_id'].'');
                                        $_SESSION['main_alert'] = 'zorunlu';
                                    }




                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                        /*  <========SON=========>>> Ürün Bilgileri Sekmesi SON */

                            /* Fiyat & Kargo */
                            if($_POST['tab'] == 'product_price' && isset($_POST['price_shipping_update'])  ) {
                                productControl($_POST['product_id']);
                                if ($Sql->rowCount() > '0') {

                                   $kdvTip = $_POST['kdv'];
                                   if($kdvTip == '1' || $kdvTip == '2' ) {
                                       if ($_POST['kdv_oran'] == null) {
                                           header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_detail_price_shipping&productID=' . $_POST['product_id'] . '');
                                           $_SESSION['main_alert'] = 'zorunlu';
                                           exit();
                                       }
                                   }

                                   if($odemeRow['kargo_sabit'] == '0' ) {
                                       $ucretliKargo = $_POST['kargo'];
                                       if($ucretliKargo == '1'  ) {
                                           if ($_POST['kargo_ucret'] == null) {
                                               header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_detail_price_shipping&productID=' . $_POST['product_id'] . '');
                                               $_SESSION['main_alert'] = 'zorunlu';
                                               exit();
                                           }
                                       }
                                   }
                                   if($_POST['eski_fiyat'] == !null  ) {
                                    $eskiFiyat = $_POST['eski_fiyat'];
                                   }else{
                                       $eskiFiyat = '0';
                                   }
                                    if($_POST['alis_fiyat'] == !null  ) {
                                        $alisFiyat = $_POST['alis_fiyat'];
                                    }else{
                                        $alisFiyat = '0';
                                    }
                                    if($_POST['fiyat'] == !null  ) {
                                        $fiyat = $_POST['fiyat'];
                                    }else{
                                        $fiyat = '0';
                                    }
                                    if($_POST['fiyat_tip2'] == !null  ) {
                                        $fiyat2 = $_POST['fiyat_tip2'];
                                    }else{
                                        $fiyat2 = '0';
                                    }
                                    if($_POST['havale_indirim_tutar'] == !null  ) {
                                        $havaleTutar = $_POST['havale_indirim_tutar'];
                                    }else{
                                        $havaleTutar = '0';
                                    }
                                    if($_POST['kargo_ucret'] == !null  ) {
                                        $kargoTutar = $_POST['kargo_ucret'];
                                    }else{
                                        $kargoTutar = '0';
                                    }
                                    if($_POST['kdv_oran'] == !null  ) {
                                        $kdvOran = $_POST['kdv_oran'];
                                    }else{
                                        $kdvOran = '18';
                                    }
                                    $guncelle = $db->prepare("UPDATE urun SET
                                                    fiyat_goster=:fiyat_goster,
                                                    indirim=:indirim,
                                                    eski_fiyat=:eski_fiyat,
                                                    alis_fiyat=:alis_fiyat,
                                                    fiyat=:fiyat,
                                                    fiyat_tip2=:fiyat_tip2,
                                                    havale_indirim_tur=:havale_indirim_tur,
                                                    havale_indirim_tutar=:havale_indirim_tutar,
                                                    kdv=:kdv,
                                                    kdv_oran=:kdv_oran,
                                                    kargo=:kargo,
                                                    kargo_tipi=:kargo_tipi,
                                                    kargo_ucret=:kargo_ucret,
                                                    kargo_desi=:kargo_desi,
                                                    kargo_sure=:kargo_sure,
                                                    hizli_kargo=:hizli_kargo
                                                    WHERE id={$_POST['product_id']}
                                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'fiyat_goster' => $_POST['fiyat_goster'],
                                        'indirim' => $_POST['indirim'],
                                        'eski_fiyat' => $eskiFiyat,
                                        'alis_fiyat' => $alisFiyat,
                                        'fiyat' => $fiyat,
                                        'fiyat_tip2' => $fiyat2,
                                        'havale_indirim_tur' => $_POST['havale_indirim_tur'],
                                        'havale_indirim_tutar' => $havaleTutar,
                                        'kdv' => $_POST['kdv'],
                                        'kdv_oran' => $kdvOran,
                                        'kargo' => $_POST['kargo'],
                                        'kargo_tipi' => $_POST['kargo_tipi'],
                                        'kargo_ucret' => $kargoTutar,
                                        'kargo_desi' => $_POST['kargo_desi'],
                                        'kargo_sure' => $_POST['kargo_sure'],
                                        'hizli_kargo' => $_POST['hizli_kargo']
                                    ));
                                    if($sonuc){
                                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_detail_price_shipping&productID=' . $_POST['product_id'] . '');
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }

                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> Fiyat & Kargo SON */


                            /* Açıklama */
                            if($_POST['tab'] == 'description' && isset($_POST['description_update'])  ) {
                                productControl($_POST['product_id']);
                                if ($Sql->rowCount() > '0') {



                                    $guncelle = $db->prepare("UPDATE urun SET
                                                    ek_aciklama1=:ek_aciklama1,
                                                    ek_aciklama2=:ek_aciklama2,
                                                    spot=:spot,
                                                    icerik=:icerik
                                                    WHERE id={$_POST['product_id']}
                                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'ek_aciklama1' => $_POST['ek_aciklama1'],
                                        'ek_aciklama2' => $_POST['ek_aciklama2'],
                                        'spot' => $_POST['spot'],
                                        'icerik' => $_POST['icerik']
                                    ));
                                    if($sonuc){
                                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_detail_description&productID=' . $_POST['product_id'] . '');
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }

                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> Açıklama SON */

                            /* Extra */
                            if($_POST['tab'] == 'extra' && isset($_POST['extra_update'])  ) {
                                productControl($_POST['product_id']);
                                if ($Sql->rowCount() > '0') {

                                    $guncelle = $db->prepare("UPDATE urun SET
                                                    embed=:embed,
                                                    katalog=:katalog,
                                                    ek_tabs=:ek_tabs,
                                                    ek_tabs_baslik=:ek_tabs_baslik
                                                    WHERE id={$_POST['product_id']}
                                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'embed' => $_POST['embed'],
                                        'katalog' => $_POST['katalog'],
                                        'ek_tabs' => $_POST['ek_tabs'],
                                        'ek_tabs_baslik' => $_POST['ek_tabs_baslik']
                                    ));
                                    if($sonuc){
                                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_detail_extra&productID=' . $_POST['product_id'] . '');
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }

                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> Extra SON */


                            /* SEO META */
                            if($_POST['tab'] == 'meta' && isset($_POST['meta_update'])  ) {
                                productControl($_POST['product_id']);
                                if ($Sql->rowCount() > '0') {



                                    /* Seo Title Boş ise üret */
                                    if($_POST['seo_baslik']== !null  ) {
                                        $seoTitle = $_POST['seo_baslik'];
                                    }else{
                                        $seoTitle = $row['baslik'];
                                    }
                                    /*  <========SON=========>>> Seo Title Boş ise üret SON */

                                    /* Seo url yoksa Üret */
                                    if($_POST['seo_url']== !null  ) {
                                        $seo_url = $_POST['seo_url'];
                                    }else{
                                        $seo_url = seo($row['baslik']);
                                    }
                                    /*  <========SON=========>>> Seo url yoksa Üret SON */

                                    $guncelle = $db->prepare("UPDATE urun SET
                                                    tags=:tags,
                                                    meta_desc=:meta_desc,
                                                    seo_baslik=:seo_baslik,
                                                    seo_url=:seo_url
                                                    WHERE id={$_POST['product_id']}
                                                    ");
                                    $sonuc = $guncelle->execute(array(
                                        'tags' => $_POST['tags'],
                                        'meta_desc' => $_POST['meta_desc'],
                                        'seo_baslik' => $seoTitle,
                                        'seo_url' => $seo_url
                                    ));
                                    if($sonuc){
                                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_detail_seo&productID=' . $_POST['product_id'] . '');
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatası';
                                    }

                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> SEO META SON */

                            /* Other */
                            if($_POST['tab'] == 'other' && isset($_POST['other_update'])  ) {
                                productControl($_POST['product_id']);
                                if ($Sql->rowCount() > '0') {
                                    if($_POST['urun_id'] ) {
                                        /* Gelen ürün idsini import et ve geri dön */
                                        $urunIDS = $_POST['urun_id'];
                                        foreach ($urunIDS as $idkey){
                                            $kontrol = $db->prepare("select * from urundetay_benzer_urun where urun_id=:urun_id and detay_id=:detay_id ");
                                            $kontrol->execute(array(
                                                'urun_id' => $idkey,
                                                'detay_id' => $_POST['product_id']
                                            ));
                                            if($kontrol->rowCount()<='0'  ) {
                                                $kaydet = $db->prepare("INSERT INTO urundetay_benzer_urun SET
                                                   urun_id=:urun_id,     
                                                   detay_id=:detay_id,
                                                   sira=:sira
                                                ");
                                                $sonuc = $kaydet->execute(array(
                                                    'urun_id' => $idkey,
                                                    'detay_id' => $_POST['product_id'],
                                                    'sira' => '1',
                                                ));
                                            }else{
                                                    $_SESSION['adding_problem'] = 'problem';
                                            }
                                        }
                                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_detail_other&productID=' . $_POST['product_id'] . '');
                                        /*  <========SON=========>>> Gelen ürün idsini import et ve geri dön SON */
                                    }else{
                                        header('Location:' . $ayar['panel_url'] . 'pages.php?page=product_detail_other&productID=' . $_POST['product_id'] . '');
                                        $_SESSION['main_alert'] = 'zorunlu';
                                    }
                                }else{
                                    header('Location:'.$ayar['site_url'].'404');
                                }
                            }
                            /*  <========SON=========>>> Other SON */


                        }else{
                            header('Location:'.$ayar['site_url'].'404');
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }
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