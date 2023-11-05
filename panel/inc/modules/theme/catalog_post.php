<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if($yetki['demo'] != '1' ) {
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'product_box' || $_GET['status'] == 'firsat_showcase_bg' || $_GET['status'] == 'firsat_showcase_bg_delete' || $_GET['status'] == 'firsat_showcase'  || $_GET['status'] == 'banner2_box_update' || $_GET['status'] == 'banner2_bg_delete'  || $_GET['status'] == 'banner2_bg_update' || $_GET['status'] == 'banner2_update'  ||  $_GET['status'] == 'banner1_bg_update'  ||  $_GET['status'] == 'banner1_bg_delete' ||  $_GET['status'] == 'banner1_update'  || $_GET['status'] == 'probanner_update'  || $_GET['status'] == 'tab_showcase_sort' ||  $_GET['status'] == 'tab_showcase_bg' ||  $_GET['status'] == 'tab_showcase_bg_delete' ||$_GET['status'] == 'tab_showcase_update' ||  $_GET['status'] == 'brand_detail_page' || $_GET['status'] == 'tbox_main_update' || $_GET['status'] == 'brand_bg_delete' || $_GET['status'] == 'brand_bg_update' || $_GET['status'] == 'brand_main_update' || $_GET['status'] == 'product_detail'  || $_GET['status'] == 'category_main_update' || $_GET['status']== 'category_nav' || $_GET['status'] == 'category_sort_update' || $_GET['status'] == 'category_filtre')  {
            function colorFormat($degisken){
                $isim  = $degisken;
                $eski   = '#';
                $yeni   = '';
                $isim = str_replace($eski, $yeni, $isim);
                return $isim;
            }
            /* Ürün Kutulaı */
            if($_GET['status'] == 'product_box'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    if($_POST['box_action']== '0'  ) {
                     $aksiyon = '0';
                    }else{
                        $aksiyon = $_POST['kutu_aksiyon_tip'];
                    }

                    $guncelle = $db->prepare("UPDATE urun_kutu SET
                            resim_w=:resim_w,
                            resim_h=:resim_h,
                            resim_big_w=:resim_big_w,
                            resim_big_h=:resim_big_h,
                            kutu_arkaplan=:kutu_arkaplan,
                            kutu_shadow=:kutu_shadow,
                            kutu_radius=:kutu_radius,
                            kutu_border_renk=:kutu_border_renk,
                            kutu_kargo_renk=:kutu_kargo_renk,
                            kutu_yazi_renk=:kutu_yazi_renk,
                            kutu_fiyat_renk=:kutu_fiyat_renk,
                            kutu_eskifiyat_renk=:kutu_eskifiyat_renk,
                            kutu_marka_goster=:kutu_marka_goster,
                            kutu_marka_renk=:kutu_marka_renk,
                            kutu_aksiyon_tip=:kutu_aksiyon_tip,
                            kutu_sepet_button=:kutu_sepet_button,
                            kutu_fav_button=:kutu_fav_button,
                            kutu_compare_button=:kutu_compare_button,
                            kutu_kargo_goster=:kutu_kargo_goster,
                            kutu_indirim_goster=:kutu_indirim_goster,
                            kutu_yeni_ribbon=:kutu_yeni_ribbon,
                            kutu_grupfiyat_button=:kutu_grupfiyat_button,
                            kutu_ozelfiyat_bg=:kutu_ozelfiyat_bg,
                            kutu_ozelfiyat_text=:kutu_ozelfiyat_text,
                            kutu_star_rate=:kutu_star_rate,
                            star_color=:star_color,
                            star_pasif_color=:star_pasif_color,
                            border_width=:border_width
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'resim_w' => $_POST['resim_w'],
                        'resim_h' => $_POST['resim_h'],
                        'resim_big_w' => $_POST['resim_big_w'],
                        'resim_big_h' => $_POST['resim_big_h'],
                        'kutu_arkaplan' => colorFormat($_POST['kutu_arkaplan']),
                        'kutu_shadow' => $_POST['kutu_shadow'],
                        'kutu_radius' => $_POST['kutu_radius'],
                        'kutu_border_renk' => colorFormat($_POST['kutu_border_renk']),
                        'kutu_kargo_renk' => colorFormat($_POST['kutu_kargo_renk']),
                        'kutu_yazi_renk' => colorFormat($_POST['kutu_yazi_renk']),
                        'kutu_fiyat_renk' => colorFormat($_POST['kutu_fiyat_renk']),
                        'kutu_eskifiyat_renk' => colorFormat($_POST['kutu_eskifiyat_renk']),
                        'kutu_marka_goster' => $_POST['kutu_marka_goster'],
                        'kutu_marka_renk' => colorFormat($_POST['kutu_marka_renk']),
                        'kutu_aksiyon_tip' => $aksiyon,
                        'kutu_sepet_button' => $_POST['kutu_sepet_button'],
                        'kutu_fav_button' => $_POST['kutu_fav_button'],
                        'kutu_compare_button' => $_POST['kutu_compare_button'],
                        'kutu_kargo_goster' => $_POST['kutu_kargo_goster'],
                        'kutu_indirim_goster' => $_POST['kutu_indirim_goster'],
                        'kutu_yeni_ribbon' => $_POST['kutu_yeni_ribbon'],
                        'kutu_grupfiyat_button' => $_POST['kutu_grupfiyat_button'],
                        'kutu_ozelfiyat_bg' => colorFormat($_POST['kutu_ozelfiyat_bg']),
                        'kutu_ozelfiyat_text' => colorFormat($_POST['kutu_ozelfiyat_text']),
                        'kutu_star_rate' => $_POST['kutu_star_rate'],
                        'star_color' => colorFormat($_POST['star_color']),
                        'star_pasif_color' => colorFormat($_POST['star_pasif_color']),
                        'border_width' => $_POST['border_width']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_product_box');
                    }else{
                    echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Ürün Kutulaı SON */

            /* Ürün Detay Sayfası */
            if($_GET['status'] == 'product_detail'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    if($_POST['galeri_thumb']  ) {
                     $thumbsayisi = trim(strip_tags($_POST['galeri_thumb']));
                     if($thumbsayisi == '3' || $thumbsayisi == '4' || $thumbsayisi == '5'|| $thumbsayisi == '6' || $thumbsayisi == '7' || $thumbsayisi == '8' ) {
                      $thumbcek = $thumbsayisi;
                     }else{
                         $thumbcek = '3';
                     }
                    }

                    $guncelle = $db->prepare("UPDATE urun_detay SET
                            urundetay_aktif_tab=:urundetay_aktif_tab,
                            urundetay_aktif_tab_yazi=:urundetay_aktif_tab_yazi,
                            detay_font=:detay_font,
                            galeri_tema=:galeri_tema,
                            galeri_thumb=:galeri_thumb,
                            detay_bg=:detay_bg,
                            detay_sepet_button=:detay_sepet_button,
                            detay_marka_goster=:detay_marka_goster,
                            detay_marka_tip=:detay_marka_tip,
                            detay_stok_goster=:detay_stok_goster,
                            detay_urunkod_goster=:detay_urunkod_goster,
                            detay_fiyatkazanc=:detay_fiyatkazanc,
                            detay_havale_info=:detay_havale_info,
                            detay_infobox_border=:detay_infobox_border,
                            detay_more_comment_button=:detay_more_comment_button,
                            detay_yorum_oval_bg=:detay_yorum_oval_bg,
                            detay_yorumyap_button=:detay_yorumyap_button,
                            urun_yorum_onay=:urun_yorum_onay,
                            star_rate=:star_rate,
                            sosyal_ikon=:sosyal_ikon
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'urundetay_aktif_tab' => colorFormat($_POST['urundetay_aktif_tab']),
                        'urundetay_aktif_tab_yazi' => colorFormat($_POST['urundetay_aktif_tab_yazi']),
                        'detay_font' => $_POST['detay_font'],
                        'galeri_tema' => $_POST['galeri_tema'],
                        'galeri_thumb' => $thumbcek,
                        'detay_bg' => colorFormat($_POST['detay_bg']),
                        'detay_sepet_button' => $_POST['detay_sepet_button'],
                        'detay_marka_goster' => $_POST['detay_marka_goster'],
                        'detay_marka_tip' => $_POST['detay_marka_tip'],
                        'detay_stok_goster' => $_POST['detay_stok_goster'],
                        'detay_urunkod_goster' => $_POST['detay_urunkod_goster'],
                        'detay_fiyatkazanc' => $_POST['detay_fiyatkazanc'],
                        'detay_havale_info' => $_POST['detay_havale_info'],
                        'detay_infobox_border' => colorFormat($_POST['detay_infobox_border']),
                        'detay_more_comment_button' => $_POST['detay_more_comment_button'],
                        'detay_yorum_oval_bg' => $_POST['detay_yorum_oval_bg'],
                        'detay_yorumyap_button' => $_POST['detay_yorumyap_button'],
                        'urun_yorum_onay' => $_POST['urun_yorum_onay'],
                        'star_rate' => $_POST['star_rate'],
                        'sosyal_ikon' => $_POST['sosyal_ikon']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_product_detail');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Ürün Detay Sayfası SON */

            /* Category Detail */
            if($_GET['status'] == 'category_main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE urun_cat_ayar SET
                            detay_arkaplan=:detay_arkaplan,
                            detay_font=:detay_font,
                            urun_liste_limit=:urun_liste_limit,
                            sayfalama_hiza=:sayfalama_hiza,
                            urun_box_gorunum_tur=:urun_box_gorunum_tur,
                            checkbox_border=:checkbox_border,
                            checkbox_bg=:checkbox_bg,
                            baslik_yer=:baslik_yer,
                            baslik_color=:baslik_color,
                            aciklama_durum=:aciklama_durum,
                            spot_color=:spot_color,
                            cat_href_color=:cat_href_color
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'detay_arkaplan' => colorFormat($_POST['detay_arkaplan']),
                        'detay_font' => $_POST['detay_font'],
                        'urun_liste_limit' => $_POST['urun_liste_limit'],
                        'sayfalama_hiza' => $_POST['sayfalama_hiza'],
                        'urun_box_gorunum_tur' => $_POST['urun_box_gorunum_tur'],
                        'checkbox_border' => colorFormat($_POST['checkbox_border']),
                        'checkbox_bg' => colorFormat($_POST['checkbox_bg']),
                        'baslik_yer' => $_POST['baslik_yer'],
                        'baslik_color' => colorFormat($_POST['baslik_color']),
                        'aciklama_durum' => $_POST['aciklama_durum'],
                        'spot_color' => colorFormat($_POST['spot_color']),
                        'cat_href_color' => colorFormat($_POST['cat_href_color'])
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_cat_detail');
                        $_SESSION['collepse_status'] = 'genelAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Category Detail SON */

            /* Sol navi ayarları */
            if($_GET['status'] == 'category_nav'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE urun_cat_ayar SET
                            sol_nav_tip=:sol_nav_tip,
                            sol_nav_bg=:sol_nav_bg,
                            sol_nav_border=:sol_nav_border,
                            sol_nav_head_color=:sol_nav_head_color,
                            sol_nav_text_color=:sol_nav_text_color,
                            sol_nav_scroll=:sol_nav_scroll,
                            sol_nav_scroll_alt=:sol_nav_scroll_alt,
                            sol_nav_ayirac=:sol_nav_ayirac,
                            altkat_padding=:altkat_padding,
                            altkat_box_bg=:altkat_box_bg,
                            altkat_box_bg_hover=:altkat_box_bg_hover,
                            altkat_box_text=:altkat_box_text,
                            altkat_box_text_hover=:altkat_box_text_hover,
                            altkat_box_border=:altkat_box_border,
                            altkat_openbox_border=:altkat_openbox_border,
                            altkat_openbox_shadow=:altkat_openbox_shadow
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'sol_nav_tip' => $_POST['sol_nav_tip'],
                        'sol_nav_bg' => colorFormat($_POST['sol_nav_bg']),
                        'sol_nav_border' => colorFormat($_POST['sol_nav_border']),
                        'sol_nav_head_color' => colorFormat($_POST['sol_nav_head_color']),
                        'sol_nav_text_color' => colorFormat($_POST['sol_nav_text_color']),
                        'sol_nav_scroll' => colorFormat($_POST['sol_nav_scroll']),
                        'sol_nav_scroll_alt' => colorFormat($_POST['sol_nav_scroll_alt']),
                        'sol_nav_ayirac' => colorFormat($_POST['sol_nav_ayirac']),
                        'altkat_padding' => $_POST['altkat_padding'],
                        'altkat_box_bg' => colorFormat($_POST['altkat_box_bg']),
                        'altkat_box_bg_hover' => colorFormat($_POST['altkat_box_bg_hover']),
                        'altkat_box_text' => colorFormat($_POST['altkat_box_text']),
                        'altkat_box_text_hover' => colorFormat($_POST['altkat_box_text_hover']),
                        'altkat_box_border' => colorFormat($_POST['altkat_box_border']),
                        'altkat_openbox_border' => colorFormat($_POST['altkat_openbox_border']),
                        'altkat_openbox_shadow' => $_POST['altkat_openbox_shadow']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_cat_detail');
                        $_SESSION['collepse_status'] = 'navAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Sol navi ayarları SON */

            /* Cat Sıralama */
            if($_GET['status'] == 'category_sort_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE urun_cat_ayar SET
                            siralama_secim=:siralama_secim,
                            sirala_harf=:sirala_harf,
                            sirala_artan=:sirala_artan,
                            sirala_azalan=:sirala_azalan,
                            sirala_yeni=:sirala_yeni,
                            sirala_populer=:sirala_populer
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'siralama_secim' => $_POST['siralama_secim'],
                        'sirala_harf' => $_POST['sirala_harf'],
                        'sirala_artan' => $_POST['sirala_artan'],
                        'sirala_azalan' => $_POST['sirala_azalan'],
                        'sirala_yeni' => $_POST['sirala_yeni'],
                        'sirala_populer' => $_POST['sirala_populer']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_cat_detail');
                        $_SESSION['collepse_status'] = 'sortAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Cat Sıralama SON */

            /* Cat Filtre */
            if($_GET['status'] == 'category_filtre'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE urun_cat_ayar SET
                            filtre_bedavakargo=:filtre_bedavakargo,
                            filtre_yeniler=:filtre_yeniler,
                            filtre_firsatlar=:filtre_firsatlar,
                            filtre_indirimler=:filtre_indirimler,
                            filtre_taksitler=:filtre_taksitler,
                            filtre_hizlikargo=:filtre_hizlikargo,
                            filtre_stok=:filtre_stok,
                            filtre_editor=:filtre_editor,
                            secili_filtre_button=:secili_filtre_button,
                            tumfiltre_kaldir_button=:tumfiltre_kaldir_button,
                            fiyat_range_bg=:fiyat_range_bg,
                            fiyat_range_ball=:fiyat_range_ball,
                            fiyat_range_price_bg=:fiyat_range_price_bg,
                            fiyat_range_price_text=:fiyat_range_price_text,
                            fiyat_range_price_border=:fiyat_range_price_border,
                            fiyat_range_button=:fiyat_range_button
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'filtre_bedavakargo' => $_POST['filtre_bedavakargo'],
                        'filtre_yeniler' => $_POST['filtre_yeniler'],
                        'filtre_firsatlar' => $_POST['filtre_firsatlar'],
                        'filtre_indirimler' => $_POST['filtre_indirimler'],
                        'filtre_taksitler' => $_POST['filtre_taksitler'],
                        'filtre_hizlikargo' => $_POST['filtre_hizlikargo'],
                        'filtre_stok' => $_POST['filtre_stok'],
                        'filtre_editor' => $_POST['filtre_editor'],
                        'secili_filtre_button' => $_POST['secili_filtre_button'],
                        'tumfiltre_kaldir_button' => $_POST['tumfiltre_kaldir_button'],
                        'fiyat_range_bg' => colorFormat($_POST['fiyat_range_bg']),
                        'fiyat_range_ball' => colorFormat($_POST['fiyat_range_ball']),
                        'fiyat_range_price_bg' => colorFormat($_POST['fiyat_range_price_bg']),
                        'fiyat_range_price_text' => colorFormat($_POST['fiyat_range_price_text']),
                        'fiyat_range_price_border' => colorFormat($_POST['fiyat_range_price_border']),
                        'fiyat_range_button' => $_POST['fiyat_range_button']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_cat_detail');
                        $_SESSION['collepse_status'] = 'filtreAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Cat Filtre SON */

            /* Marka Modül Ayar */
            if($_GET['status'] == 'brand_main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE urun_marka_ayar SET
                            margin=:margin,
                            padding=:padding,
                            marka_limit=:marka_limit,
                            box_bg_home=:box_bg_home,
                            round=:round,
                            border_color_home=:border_color_home,
                            modul_border=:modul_border,
                            tooltip=:tooltip,
                            yeni_sekme=:yeni_sekme
                  
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'margin' => $_POST['margin'],
                        'padding' => $_POST['padding'],
                        'marka_limit' => $_POST['marka_limit'],
                        'box_bg_home' => colorFormat($_POST['box_bg_home']),
                        'round' => $_POST['round'],
                        'border_color_home' => colorFormat($_POST['border_color_home']),
                        'modul_border' => colorFormat($_POST['modul_border']),
                        'tooltip' =>$_POST['tooltip'],
                        'yeni_sekme' => $_POST['yeni_sekme']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_brand');
                        $_SESSION['collepse_status'] = 'genelAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Marka Modül Ayar SON */

            /* Marka Modul BG */
            if($_GET['status'] == 'brand_bg_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['bg_tip']=='0' || $_POST['bg_tip'] == '1'  ) {
                        if($_POST['bg_tip']== '0'  ) {
                            /* Arkaplan Görseli */
                            if ($_FILES['bg_image']["size"] > 0) {
                                $old_img = $_POST['old_bg'];
                                $file_format = $_FILES["bg_image"];
                                $kaynak = $_FILES["bg_image"]["tmp_name"];
                                $uzanti = explode(".", $_FILES['bg_image']['name']);
                                $random = rand(0, (int)99999);
                                $random2 = rand(0, (int)999);
                                $filename = trim(addslashes($_FILES['bg_image']['name']));
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
                                $target = "../images/uploads/" . $file_name;

                                if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $guncelle = $db->prepare("UPDATE urun_marka_ayar SET
                                         bg_image=:bg_image,
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                    $sonuc = $guncelle->execute(array(
                                        'bg_image' => $file_name,
                                        'bg_tip' => '0',
                                        'bg_dark' => $_POST['bg_dark'],
                                        'bg_durum' => $_POST['bg_durum']
                                    ));
                                    if($sonuc){
                                        if($old_img == !null || isset($old_img) ) {
                                            unlink("../images/uploads/$old_img");
                                        }
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_brand');
                                        $_SESSION['collepse_status'] = 'bgAcc';
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_brand');
                                    $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'filetype';
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE urun_marka_ayar SET
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'bg_tip' => '0',
                                    'bg_dark' => $_POST['bg_dark'],
                                    'bg_durum' => $_POST['bg_durum']
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_brand');
                                    $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                                /*  <========SON=========>>> Görsel Eklemeden Diğer Ayar Kayıtları SON */
                            }
                            /*  <========SON=========>>> Arkaplan Görseli SON */
                        }
                        if($_POST['bg_tip']== '1'  ) {
                            /* Sadece Renk */
                            $guncelle = $db->prepare("UPDATE urun_marka_ayar SET
                                    bg_color=:bg_color,
                                    bg_tip=:bg_tip
                             WHERE id='1'      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'bg_color' => colorFormat($_POST['bg_color']),
                                'bg_tip' => '1'
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_brand');
                                $_SESSION['main_alert'] = 'success';
                                $_SESSION['collepse_status'] = 'bgAcc';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Sadece Renk SON */
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'brand_bg_delete'  ) {
                $sorgu = $db->prepare("select * from urun_marka_ayar where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink("../images/uploads/$row[bg_image]");
                $guncelle = $db->prepare("UPDATE urun_marka_ayar SET
                            bg_image=:bg_image
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'bg_image' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_brand');
                    $_SESSION['main_alert'] = 'success';
                    $_SESSION['collepse_status'] = 'bgAcc';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            /*  <========SON=========>>> Marka Modul BG SON */

            /* Marka Diğer Ayar */
            if($_GET['status'] == 'brand_detail_page'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE urun_marka_ayar SET
                            detay_font=:detay_font,
                            detay_bg=:detay_bg,
                            tags=:tags,
                            meta_desc=:meta_desc
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'detay_font' => $_POST['detay_font'],
                        'detay_bg' => colorFormat($_POST['detay_bg']),
                        'tags' => $_POST['tags'],
                        'meta_desc' => $_POST['meta_desc']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_brand');
                        $_SESSION['collepse_status'] = 'detailAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Marka Diğer Ayar SON */

            /* Ticaret Kutu Ayar */
            if($_GET['status'] == 'tbox_main_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE tkutu_ayar SET
                            tkutu_font=:tkutu_font,
                            tkutu_ana_arkaplan=:tkutu_ana_arkaplan,
                            tkutu_arkaplan=:tkutu_arkaplan,
                            tkutu_border=:tkutu_border,
                            tkutu_baslik_renk=:tkutu_baslik_renk,
                            tkutu_icon_renk=:tkutu_icon_renk,
                            tkutu_spot_renk=:tkutu_spot_renk,
                            tkutu_main_border=:tkutu_main_border,
                            tkutu_footer=:tkutu_footer
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'tkutu_font' => $_POST['tkutu_font'],
                        'tkutu_ana_arkaplan' => colorFormat($_POST['tkutu_ana_arkaplan']),
                        'tkutu_arkaplan' => colorFormat($_POST['tkutu_arkaplan']),
                        'tkutu_border' => colorFormat($_POST['tkutu_border']),
                        'tkutu_baslik_renk' => colorFormat($_POST['tkutu_baslik_renk']),
                        'tkutu_icon_renk' => colorFormat($_POST['tkutu_icon_renk']),
                        'tkutu_spot_renk' => colorFormat($_POST['tkutu_spot_renk']),
                        'tkutu_main_border' => colorFormat($_POST['tkutu_main_border']),
                        'tkutu_footer' => $_POST['tkutu_footer']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_tbox');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Ticaret Kutu Ayar SON */


            /* Tab Product Post */
            if($_GET['status'] == 'tab_showcase_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE vitrin_secenekli_ayar SET
                            secenekvitrin_baslik_font=:secenekvitrin_baslik_font,
                            secenekvitrin_margin=:secenekvitrin_margin,
                            secenekvitrin_padding=:secenekvitrin_padding,
                            secenekvitrin_border=:secenekvitrin_border,
                            secenekvitrin_grid_sayi=:secenekvitrin_grid_sayi,
                            secenekvitrin_tab_urun_limit=:secenekvitrin_tab_urun_limit,
                            secenekvitrin_tab_baslikspace=:secenekvitrin_tab_baslikspace,
                            secenekvitrin_tab_baslik_size=:secenekvitrin_tab_baslik_size,
                            secenekvitrin_tab_baslik_weight=:secenekvitrin_tab_baslik_weight,
                            secenekvitrin_aktif_tab_renk=:secenekvitrin_aktif_tab_renk,
                            secenekvitrin_aktif_tab_yazi=:secenekvitrin_aktif_tab_yazi,
                            secenekvitrin_aktif_tab_border=:secenekvitrin_aktif_tab_border,
                            secenekvitrin_tab_renk=:secenekvitrin_tab_renk,
                            secenekvitrin_tab_yazi=:secenekvitrin_tab_yazi,
                            secenekvitrin_tab_border=:secenekvitrin_tab_border,
                            secenekvitrin_tab_radius=:secenekvitrin_tab_radius,
                            secenekvitrin_tab_margin=:secenekvitrin_tab_margin
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'secenekvitrin_baslik_font' => $_POST['secenekvitrin_baslik_font'],
                        'secenekvitrin_margin' => $_POST['secenekvitrin_margin'],
                        'secenekvitrin_padding' => $_POST['secenekvitrin_padding'],
                        'secenekvitrin_border' => colorFormat($_POST['secenekvitrin_border']),
                        'secenekvitrin_grid_sayi' => $_POST['secenekvitrin_grid_sayi'],
                        'secenekvitrin_tab_urun_limit' => $_POST['secenekvitrin_tab_urun_limit'],
                        'secenekvitrin_tab_baslikspace' => $_POST['secenekvitrin_tab_baslikspace'],
                        'secenekvitrin_tab_baslik_size' => $_POST['secenekvitrin_tab_baslik_size'],
                        'secenekvitrin_tab_baslik_weight' => $_POST['secenekvitrin_tab_baslik_weight'],
                        'secenekvitrin_aktif_tab_renk' => colorFormat($_POST['secenekvitrin_aktif_tab_renk']),
                        'secenekvitrin_aktif_tab_yazi' => colorFormat($_POST['secenekvitrin_aktif_tab_yazi']),
                        'secenekvitrin_aktif_tab_border' => colorFormat($_POST['secenekvitrin_aktif_tab_border']),
                        'secenekvitrin_tab_renk' => colorFormat($_POST['secenekvitrin_tab_renk']),
                        'secenekvitrin_tab_yazi' => colorFormat($_POST['secenekvitrin_tab_yazi']),
                        'secenekvitrin_tab_border' => colorFormat($_POST['secenekvitrin_tab_border']),
                        'secenekvitrin_tab_radius' => $_POST['secenekvitrin_tab_radius'],
                        'secenekvitrin_tab_margin' => $_POST['secenekvitrin_tab_margin'],
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_tab');
                        $_SESSION['collepse_status'] = 'genelAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'tab_showcase_bg'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['secenekvitrin_bg_tip']=='0' || $_POST['secenekvitrin_bg_tip'] == '1'  ) {
                        if($_POST['secenekvitrin_bg_tip']== '0'  ) {
                            /* Arkaplan Görseli */
                            if ($_FILES['secenekvitrin_bg_image']["size"] > 0) {
                                $old_img = $_POST['old_bg'];
                                $file_format = $_FILES["secenekvitrin_bg_image"];
                                $kaynak = $_FILES["secenekvitrin_bg_image"]["tmp_name"];
                                $uzanti = explode(".", $_FILES['secenekvitrin_bg_image']['name']);
                                $random = rand(0, (int)99999);
                                $random2 = rand(0, (int)999);
                                $filename = trim(addslashes($_FILES['secenekvitrin_bg_image']['name']));
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
                                $target = "../images/uploads/" . $file_name;

                                if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $guncelle = $db->prepare("UPDATE vitrin_secenekli_ayar SET
                                            secenekvitrin_bg_image=:secenekvitrin_bg_image,
                                            secenekvitrin_bg_tip=:secenekvitrin_bg_tip,
                                            secenekvitrin_bg_dark=:secenekvitrin_bg_dark,
                                            secenekvitrin_bg_durum=:secenekvitrin_bg_durum
                                            WHERE id='1'
                                            ");
                                    $sonuc = $guncelle->execute(array(
                                        'secenekvitrin_bg_image' => $file_name,
                                        'secenekvitrin_bg_tip' => '0',
                                        'secenekvitrin_bg_dark' => $_POST['secenekvitrin_bg_dark'],
                                        'secenekvitrin_bg_durum' => $_POST['secenekvitrin_bg_durum']
                                    ));
                                    if($sonuc){
                                        if($old_img == !null || isset($old_img) ) {
                                            unlink("../images/uploads/$old_img");
                                        }
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_tab');
                                          $_SESSION['collepse_status'] = 'bgAcc';
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_tab');
                                      $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'filetype';
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE vitrin_secenekli_ayar SET
                                        secenekvitrin_bg_tip=:secenekvitrin_bg_tip,
                                        secenekvitrin_bg_dark=:secenekvitrin_bg_dark,
                                        secenekvitrin_bg_durum=:secenekvitrin_bg_durum
                                        WHERE id='1'
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'secenekvitrin_bg_tip' => '0',
                                    'secenekvitrin_bg_dark' => $_POST['secenekvitrin_bg_dark'],
                                    'secenekvitrin_bg_durum' => $_POST['secenekvitrin_bg_durum']
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_tab');
                                      $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                                /*  <========SON=========>>> Görsel Eklemeden Diğer Ayar Kayıtları SON */
                            }
                            /*  <========SON=========>>> Arkaplan Görseli SON */
                        }
                        if($_POST['secenekvitrin_bg_tip']== '1'  ) {
                            /* Sadece Renk */
                            $guncelle = $db->prepare("UPDATE vitrin_secenekli_ayar SET
                                secenekvitrin_bg_color=:secenekvitrin_bg_color,
                                secenekvitrin_bg_tip=:secenekvitrin_bg_tip
                                WHERE id='1'
                                ");
                            $sonuc = $guncelle->execute(array(
                                'secenekvitrin_bg_color' => colorFormat($_POST['secenekvitrin_bg_color']),
                                'secenekvitrin_bg_tip' => '1'
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_tab');
                                  $_SESSION['collepse_status'] = 'bgAcc';
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Sadece Renk SON */
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'tab_showcase_bg_delete'  ) {
                $sorgu = $db->prepare("select * from vitrin_secenekli_ayar where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink("../images/uploads/$row[secenekvitrin_bg_image]");
                $guncelle = $db->prepare("UPDATE vitrin_secenekli_ayar SET
                            secenekvitrin_bg_image=:secenekvitrin_bg_image
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'secenekvitrin_bg_image' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_tab');
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            if($_GET['status'] == 'tab_showcase_sort'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE vitrin_secenekli_ayar SET
                            secenekvitrin_aktif_tab=:secenekvitrin_aktif_tab,
                            secenekvitrin_yeni_urunler=:secenekvitrin_yeni_urunler,
                            secenekvitrin_populer_urunler=:secenekvitrin_populer_urunler,
                            secenekvitrin_indirimli_urunler=:secenekvitrin_indirimli_urunler,
                            secenekvitrin_firsat_urunleri=:secenekvitrin_firsat_urunleri,
                            secenekvitrin_editor_urunleri=:secenekvitrin_editor_urunleri,
                            secenekvitrin_bedavakargo_urunleri=:secenekvitrin_bedavakargo_urunleri,
                            secenekvitrin_hizlikargo_urunleri=:secenekvitrin_hizlikargo_urunleri
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'secenekvitrin_aktif_tab' => $_POST['secenekvitrin_aktif_tab'],
                        'secenekvitrin_yeni_urunler' => $_POST['secenekvitrin_yeni_urunler'],
                        'secenekvitrin_populer_urunler' => $_POST['secenekvitrin_populer_urunler'],
                        'secenekvitrin_indirimli_urunler' => $_POST['secenekvitrin_indirimli_urunler'],
                        'secenekvitrin_firsat_urunleri' => $_POST['secenekvitrin_firsat_urunleri'],
                        'secenekvitrin_editor_urunleri' => $_POST['secenekvitrin_editor_urunleri'],
                        'secenekvitrin_bedavakargo_urunleri' => $_POST['secenekvitrin_bedavakargo_urunleri'],
                        'secenekvitrin_hizlikargo_urunleri' => $_POST['secenekvitrin_hizlikargo_urunleri']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_tab');
                        $_SESSION['collepse_status'] = 'detailAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Tab Product Post SON */
            
            /* Görsel + Ürünler Vitrini Post */
            if($_GET['status'] == 'probanner_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE vitrin_tip1_ayar SET
                            font=:font,
                            arkaplan=:arkaplan,
                            border_color=:border_color,
                            baslik_renk=:baslik_renk,
                            spot_renk=:spot_renk,
                            urun_limit=:urun_limit,
                            vitrin_grid=:vitrin_grid,
                            gorsel_radius=:gorsel_radius,
                            gorsel_zoom=:gorsel_zoom,
                            gorsel_blur=:gorsel_blur
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'font' => $_POST['font'],
                        'arkaplan' => colorFormat($_POST['arkaplan']),
                        'border_color' => colorFormat($_POST['border_color']),
                        'baslik_renk' => colorFormat($_POST['baslik_renk']),
                        'spot_renk' => colorFormat($_POST['spot_renk']),
                        'urun_limit' => $_POST['urun_limit'],
                        'vitrin_grid' => $_POST['vitrin_grid'],
                        'gorsel_radius' => $_POST['gorsel_radius'],
                        'gorsel_zoom' => $_POST['gorsel_zoom'],
                        'gorsel_blur' => $_POST['gorsel_blur']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_bannerproduct');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Görsel + Ürünler Vitrini Post SON */
            
            /* Banner Showcase 1 */
            if($_GET['status'] == 'banner1_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE vitrin_tip2_ayar SET
                            font=:font,
                            margin=:margin,
                            padding=:padding,
                            baslik_renk=:baslik_renk,
                            spot_renk=:spot_renk,
                            baslik_border=:baslik_border,
                            border_color=:border_color,
                            vitrin_limit=:vitrin_limit,
                            round=:round,
                            baslik_letter=:baslik_letter,
                            gorsel_zoom=:gorsel_zoom,
                            yeni_sekme=:yeni_sekme
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'font' => $_POST['font'],
                        'margin' => $_POST['margin'],
                        'padding' => $_POST['padding'],
                        'baslik_renk' => colorFormat($_POST['baslik_renk']),
                        'spot_renk' => colorFormat($_POST['spot_renk']),
                        'baslik_border' => colorFormat($_POST['baslik_border']),
                        'border_color' => colorFormat($_POST['border_color']),
                        'vitrin_limit' => $_POST['vitrin_limit'],
                        'round' => $_POST['round'],
                        'baslik_letter' => $_POST['baslik_letter'],
                        'gorsel_zoom' => $_POST['gorsel_zoom'],
                        'yeni_sekme' => $_POST['yeni_sekme']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner1');
                        $_SESSION['collepse_status'] = 'genelAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'banner1_bg_delete'  ) {
                $sorgu = $db->prepare("select * from vitrin_tip2_ayar where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink("../images/uploads/$row[bg_image]");
                $guncelle = $db->prepare("UPDATE vitrin_tip2_ayar SET
                            bg_image=:bg_image
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'bg_image' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner1');
                    $_SESSION['main_alert'] = 'success';
                    $_SESSION['collepse_status'] = 'bgAcc';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            if($_GET['status'] == 'banner1_bg_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['bg_tip']=='0' || $_POST['bg_tip'] == '1'  ) {
                        if($_POST['bg_tip']== '0'  ) {
                            /* Arkaplan Görseli */
                            if ($_FILES['bg_image']["size"] > 0) {
                                $old_img = $_POST['old_bg'];
                                $file_format = $_FILES["bg_image"];
                                $kaynak = $_FILES["bg_image"]["tmp_name"];
                                $uzanti = explode(".", $_FILES['bg_image']['name']);
                                $random = rand(0, (int)99999);
                                $random2 = rand(0, (int)999);
                                $filename = trim(addslashes($_FILES['bg_image']['name']));
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
                                $target = "../images/uploads/" . $file_name;

                                if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $guncelle = $db->prepare("UPDATE vitrin_tip2_ayar SET
                                         bg_image=:bg_image,
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                    $sonuc = $guncelle->execute(array(
                                        'bg_image' => $file_name,
                                        'bg_tip' => '0',
                                        'bg_dark' => $_POST['bg_dark'],
                                        'bg_durum' => $_POST['bg_durum']
                                    ));
                                    if($sonuc){
                                        if($old_img == !null || isset($old_img) ) {
                                            unlink("../images/uploads/$old_img");
                                        }
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner1');
                                          $_SESSION['collepse_status'] = 'bgAcc';
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner1');
                                      $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'filetype';
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE vitrin_tip2_ayar SET
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'bg_tip' => '0',
                                    'bg_dark' => $_POST['bg_dark'],
                                    'bg_durum' => $_POST['bg_durum']
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner1');
                                      $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                                /*  <========SON=========>>> Görsel Eklemeden Diğer Ayar Kayıtları SON */
                            }
                            /*  <========SON=========>>> Arkaplan Görseli SON */
                        }
                        if($_POST['bg_tip']== '1'  ) {
                            /* Sadece Renk */
                            $guncelle = $db->prepare("UPDATE vitrin_tip2_ayar SET
                                    bg_color=:bg_color,
                                    bg_tip=:bg_tip
                             WHERE id='1'      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'bg_color' => colorFormat($_POST['bg_color']),
                                'bg_tip' => '1'
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner1');
                                  $_SESSION['collepse_status'] = 'bgAcc';
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Sadece Renk SON */
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner Showcase 1 SON */

            /* Banner Showcase 2 */
            if($_GET['status'] == 'banner2_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE vitrin_tip3_ayar SET
                            font=:font,
                            grid_sayi=:grid_sayi,
                            margin=:margin,
                            padding=:padding,
                            baslik_renk=:baslik_renk,
                            spot_renk=:spot_renk,
                            baslik_border=:baslik_border,
                            border_color=:border_color,
                            vitrin_limit=:vitrin_limit,
                            baslik_letter=:baslik_letter,
                            yeni_sekme=:yeni_sekme
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'font' => $_POST['font'],
                        'grid_sayi' => $_POST['grid_sayi'],
                        'margin' => $_POST['margin'],
                        'padding' => $_POST['padding'],
                        'baslik_renk' => colorFormat($_POST['baslik_renk']),
                        'spot_renk' => colorFormat($_POST['spot_renk']),
                        'baslik_border' => colorFormat($_POST['baslik_border']),
                        'border_color' => colorFormat($_POST['border_color']),
                        'vitrin_limit' => $_POST['vitrin_limit'],
                        'baslik_letter' => $_POST['baslik_letter'],
                        'yeni_sekme' => $_POST['yeni_sekme']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        $_SESSION['collepse_status'] = 'genelAcc';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner2');
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'banner2_bg_delete'  ) {
                $sorgu = $db->prepare("select * from vitrin_tip3_ayar where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink("../images/uploads/$row[bg_image]");
                $guncelle = $db->prepare("UPDATE vitrin_tip3_ayar SET
                            bg_image=:bg_image
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'bg_image' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner2');
                    $_SESSION['main_alert'] = 'success';
                    $_SESSION['collepse_status'] = 'bgAcc';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            if($_GET['status'] == 'banner2_bg_update'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['bg_tip']=='0' || $_POST['bg_tip'] == '1'  ) {
                        if($_POST['bg_tip']== '0'  ) {
                            /* Arkaplan Görseli */
                            if ($_FILES['bg_image']["size"] > 0) {
                                $old_img = $_POST['old_bg'];
                                $file_format = $_FILES["bg_image"];
                                $kaynak = $_FILES["bg_image"]["tmp_name"];
                                $uzanti = explode(".", $_FILES['bg_image']['name']);
                                $random = rand(0, (int)99999);
                                $random2 = rand(0, (int)999);
                                $filename = trim(addslashes($_FILES['bg_image']['name']));
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
                                $target = "../images/uploads/" . $file_name;

                                if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $guncelle = $db->prepare("UPDATE vitrin_tip3_ayar SET
                                         bg_image=:bg_image,
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                    $sonuc = $guncelle->execute(array(
                                        'bg_image' => $file_name,
                                        'bg_tip' => '0',
                                        'bg_dark' => $_POST['bg_dark'],
                                        'bg_durum' => $_POST['bg_durum']
                                    ));
                                    if($sonuc){
                                        if($old_img == !null || isset($old_img) ) {
                                            unlink("../images/uploads/$old_img");
                                        }
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner2');
                                         $_SESSION['collepse_status'] = 'bgAcc';
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner2');
                                     $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'filetype';
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE vitrin_tip3_ayar SET
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'bg_tip' => '0',
                                    'bg_dark' => $_POST['bg_dark'],
                                    'bg_durum' => $_POST['bg_durum']
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner2');
                                     $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                                /*  <========SON=========>>> Görsel Eklemeden Diğer Ayar Kayıtları SON */
                            }
                            /*  <========SON=========>>> Arkaplan Görseli SON */
                        }
                        if($_POST['bg_tip']== '1'  ) {
                            /* Sadece Renk */
                            $guncelle = $db->prepare("UPDATE vitrin_tip3_ayar SET
                                    bg_color=:bg_color,
                                    bg_tip=:bg_tip
                             WHERE id='1'      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'bg_color' => colorFormat($_POST['bg_color']),
                                'bg_tip' => '1'
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner2');
                                 $_SESSION['collepse_status'] = 'bgAcc';
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Sadece Renk SON */
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'banner2_box_update'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE vitrin_tip3_ayar SET
                            box_border=:box_border,
                            box_disbaslik=:box_disbaslik,
                            box_disbaslik_bg=:box_disbaslik_bg,
                            box_disbaslik_color=:box_disbaslik_color,
                            box_icbaslik=:box_icbaslik,
                            box_icbaslik_button=:box_icbaslik_button,
                            box_icbaslik_blur=:box_icbaslik_blur,
                            box_icbaslik_zoom=:box_icbaslik_zoom
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'box_border' => colorFormat($_POST['box_border']),
                        'box_disbaslik' => $_POST['box_disbaslik'],
                        'box_disbaslik_bg' => colorFormat($_POST['box_disbaslik_bg']),
                        'box_disbaslik_color' => colorFormat($_POST['box_disbaslik_color']),
                        'box_icbaslik' => $_POST['box_icbaslik'],
                        'box_icbaslik_button' => $_POST['box_icbaslik_button'],
                        'box_icbaslik_blur' => $_POST['box_icbaslik_blur'],
                        'box_icbaslik_zoom' => $_POST['box_icbaslik_zoom']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_banner2');
                        $_SESSION['collepse_status'] = 'boxAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Banner Showcase 2 SON */


            /* Fırsatlar Vitrini */
            if($_GET['status'] == 'firsat_showcase'  ) {
                if($_POST && isset($_POST['update'])  ) {

                    $guncelle = $db->prepare("UPDATE vitrin_firsat SET
                            font=:font,
                            margin=:margin,
                            padding=:padding,
                            baslik_renk=:baslik_renk,
                            spot_renk=:spot_renk,
                            baslik_border=:baslik_border,
                            border_color=:border_color,
                            vitrin_limit=:vitrin_limit,
                            baslik_letter=:baslik_letter
                     WHERE id='1'      
                    ");
                    $sonuc = $guncelle->execute(array(
                        'font' => $_POST['font'],
                        'margin' => $_POST['margin'],
                        'padding' => $_POST['padding'],
                        'baslik_renk' => colorFormat($_POST['baslik_renk']),
                        'spot_renk' => colorFormat($_POST['spot_renk']),
                        'baslik_border' => colorFormat($_POST['baslik_border']),
                        'border_color' => colorFormat($_POST['border_color']),
                        'vitrin_limit' => $_POST['vitrin_limit'],
                        'baslik_letter' => $_POST['baslik_letter']
                    ));
                    if($sonuc){
                        $_SESSION['main_alert'] = 'success';
                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_countdown');
                        $_SESSION['collepse_status'] = 'genelAcc';
                    }else{
                        echo 'Veritabanı Hatası';
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            if($_GET['status'] == 'firsat_showcase_bg_delete'  ) {
                $sorgu = $db->prepare("select * from vitrin_firsat where id='1' ");
                $sorgu->execute();
                $row = $sorgu->fetch(PDO::FETCH_ASSOC);
                unlink("../images/uploads/$row[bg_image]");
                $guncelle = $db->prepare("UPDATE vitrin_firsat SET
                            bg_image=:bg_image
                     WHERE id='1'      
                    ");
                $sonuc = $guncelle->execute(array(
                    'bg_image' => null,
                ));
                if($sonuc){
                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_countdown');
                    $_SESSION['collepse_status'] = 'bgAcc';
                    $_SESSION['main_alert'] = 'success';
                }else{
                    echo 'Veritabanı Hatası';
                }
            }
            if($_GET['status'] == 'firsat_showcase_bg'  ) {
                if($_POST && isset($_POST['update'])  ) {
                    if($_POST['bg_tip']=='0' || $_POST['bg_tip'] == '1'  ) {
                        if($_POST['bg_tip']== '0'  ) {
                            /* Arkaplan Görseli */
                            if ($_FILES['bg_image']["size"] > 0) {
                                $old_img = $_POST['old_bg'];
                                $file_format = $_FILES["bg_image"];
                                $kaynak = $_FILES["bg_image"]["tmp_name"];
                                $uzanti = explode(".", $_FILES['bg_image']['name']);
                                $random = rand(0, (int)99999);
                                $random2 = rand(0, (int)999);
                                $filename = trim(addslashes($_FILES['bg_image']['name']));
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
                                $target = "../images/uploads/" . $file_name;

                                if ( $file_format['type'] == 'image/jpg' || $file_format['type'] == 'image/jpeg' || $file_format['type'] == 'image/png' || $file_format['type'] == 'image/gif' || $file_format['type'] == 'image/svg+xml' ) {
                                    $gitti = move_uploaded_file($kaynak, $target);
                                    $guncelle = $db->prepare("UPDATE vitrin_firsat SET
                                         bg_image=:bg_image,
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                    $sonuc = $guncelle->execute(array(
                                        'bg_image' => $file_name,
                                        'bg_tip' => '0',
                                        'bg_dark' => $_POST['bg_dark'],
                                        'bg_durum' => $_POST['bg_durum']
                                    ));
                                    if($sonuc){
                                        if($old_img == !null || isset($old_img) ) {
                                            unlink("../images/uploads/$old_img");
                                        }
                                        header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_countdown');
                                        $_SESSION['collepse_status'] = 'bgAcc';
                                        $_SESSION['main_alert'] = 'success';
                                    }else{
                                        echo 'Veritabanı Hatasıss';
                                    }
                                }else{
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_countdown');
                                    $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'filetype';
                                }
                            }else{
                                /* Görsel Eklemeden Diğer Ayar Kayıtları */
                                $guncelle = $db->prepare("UPDATE vitrin_firsat SET
                                         bg_tip=:bg_tip,
                                         bg_dark=:bg_dark,
                                         bg_durum=:bg_durum
                                         WHERE id='1'      
                                        ");
                                $sonuc = $guncelle->execute(array(
                                    'bg_tip' => '0',
                                    'bg_dark' => $_POST['bg_dark'],
                                    'bg_durum' => $_POST['bg_durum']
                                ));
                                if($sonuc){
                                    header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_countdown');
                                    $_SESSION['collepse_status'] = 'bgAcc';
                                    $_SESSION['main_alert'] = 'success';
                                }else{
                                    echo 'Veritabanı Hatası';
                                }
                                /*  <========SON=========>>> Görsel Eklemeden Diğer Ayar Kayıtları SON */
                            }
                            /*  <========SON=========>>> Arkaplan Görseli SON */
                        }
                        if($_POST['bg_tip']== '1'  ) {
                            /* Sadece Renk */
                            $guncelle = $db->prepare("UPDATE vitrin_firsat SET
                                    bg_color=:bg_color,
                                    bg_tip=:bg_tip
                             WHERE id='1'      
                            ");
                            $sonuc = $guncelle->execute(array(
                                'bg_color' => colorFormat($_POST['bg_color']),
                                'bg_tip' => '1'
                            ));
                            if($sonuc){
                                header('Location:'.$ayar['panel_url'].'pages.php?page=theme_showcase_countdown');
                                $_SESSION['collepse_status'] = 'bgAcc';
                                $_SESSION['main_alert'] = 'success';
                            }else{
                                echo 'Veritabanı Hatası';
                            }
                            /*  <========SON=========>>> Sadece Renk SON */
                        }
                    }else{
                        header('Location:'.$ayar['site_url'].'404');
                    }

                }else{
                    header('Location:'.$ayar['site_url'].'404');
                }
            }
            /*  <========SON=========>>> Fırsatlar Vitrini SON */

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