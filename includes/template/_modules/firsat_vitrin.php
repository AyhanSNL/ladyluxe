<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?> <?php $FirsatlarVitriniSql = $db->prepare("select * from vitrin_firsat where id='1'");$FirsatlarVitriniSql->execute();$firsatRow = $FirsatlarVitriniSql->fetch(PDO::FETCH_ASSOC);$gruplimit = $firsatRow['vitrin_limit'];$urunKutuAyar = $db->prepare("select * from urun_kutu where id='1'");$urunKutuAyar->execute();$urunKutuRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);$firsatUrunCek = $db->prepare("select * from vitrin_firsat_urunler where dil=:dil order by sira asc limit $gruplimit ");$firsatUrunCek->execute(array('dil' => $_SESSION['dil'])); ?><div class="firsatlar-urun-module-main-div"><div class="firsatlar-urun-module-inside-area"><div class="urun-kutulari-main"><?php if($diller['anasayfa-firsatlar-vitrini-baslik'] == !null || $diller['anasayfa-firsatlar-vitrini-altbaslik'] == !null  ) {?><!-- Modül başlıgı ve üst başlıgı !--><div class="modules-head-text-main"><?php if($diller['anasayfa-firsatlar-vitrini-baslik'] == !null  ) {?><div class="modules-head-forbg-text-out" style="border-bottom: 1px solid #<?=$firsatRow['baslik_border']?>; "><div class="modules-head-forbg-text <?=$firsatRow['baslik_letter']?>" style="color: #<?=$firsatRow['baslik_renk']?>;     background-color: #<?=$firsatRow['bg_color']?>; "><?=$diller['anasayfa-firsatlar-vitrini-baslik']?></div></div><?php }?><div class="modules-head-text-s" style="color: #<?=$firsatRow['spot_renk']?>; margin-bottom: 0;"><?=$diller['anasayfa-firsatlar-vitrini-altbaslik']?></div></div> <!-- Modül başlıgı ve üst başlıgı SON !--><div class="swiper-countdown-list" style="height: auto !important; padding-top: 20px; padding-bottom: 20px;"><div class="swiper-wrapper" ><?php foreach ($firsatUrunCek as $firsatUrun) {$BugunKontrol = date('Y-m-d H:i:s');$sqlBugunDate = ''.$firsatUrun['son_tarih'].' '.$firsatUrun['son_time'].'';if($BugunKontrol < $sqlBugunDate  ) {$firsatDurum = '1';}else{$firsatDurum = '0';} ?><?php if($firsatDurum =='1'  ) {?><?php if($BugunKontrol < $sqlBugunDate  ) {$urunWhile = $db->prepare("select * from urun where id=:id and durum=:durum ");$urunWhile->execute(array('id' => $firsatUrun['urun_id'], 'durum' => '1'));$urunRow = $urunWhile->fetch(PDO::FETCH_ASSOC);/* Fiyatı Çıkar */if($userSorgusu->rowCount()>'0'  ) {if($uyegruplariCek->rowCount()>'0'  ) {if($uyegrup['fiyat_tip'] == '0'  ) {$box_fiyat = $urunRow['fiyat'];$box_fiyat_uyari = '0';}if($uyegrup['fiyat_tip'] == '1'  ) {if($urunRow['fiyat_tip2'] >'0' ) {$box_fiyat = $urunRow['fiyat_tip2'];$box_fiyat_uyari = '1';}else{$box_fiyat = $urunRow['fiyat'];$box_fiyat_uyari = '0';}}}else{$box_fiyat = $urunRow['fiyat'];$box_fiyat_uyari = '0';}}else{$box_fiyat = $urunRow['fiyat'];$box_fiyat_uyari = '0';}/*  <========SON=========>>> Fiyatı Çıkar SON *//* İndirim Oranı */if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) {$indirimorani = 100 - (($box_fiyat / $urunRow['eski_fiyat']) * 100);}/*  <========SON=========>>> İndirim Oranı SON *//* Ürünün Yorum ve Değerlendirme Ortalaması */$urunYildizlari = $db->prepare("SELECT SUM(yildiz) AS orta FROM urun_yorum where onay=:onay and urun_id=:urun_id; ");$urunYildizlari->execute(array('onay' => '1', 'urun_id' => $urunRow['id']));$yildizToplami = $urunYildizlari->fetch(PDO::FETCH_ASSOC);$urunYorumToplamSayi = $db->prepare("select * from urun_yorum where onay=:onay and urun_id=:urun_id ");$urunYorumToplamSayi->execute(array('onay' => '1', 'urun_id' => $urunRow['id']));$yorumcount = $urunYorumToplamSayi->rowCount();if($yorumcount == null && $yorumcount <= '0') {$yildizOrtalamasi = '0';} else {$yildizOrtalamasi = $yildizToplami['orta'] / $yorumcount;}$urun_comment_star = (int)$yildizOrtalamasi;/*  <========SON=========>>> Ürünün Yorum ve Değerlendirme Ortalaması SON *//* Varyant Sorgu */$varyantVarmi = $db->prepare("select * from detay_varyant where urun_id=:urun_id ");$varyantVarmi->execute(array('urun_id' => $urunRow['id']));/*  <========SON=========>>> Varyant Sorgu SON */ ?><div class="swiper-slide" style="height: 100% !important;" ><div class="firsat-product-box" style="height: 100%!important;"><?php if ($urunKutuRow['kutu_yeni_ribbon'] == '1') { ?><?php if($urunRow['yeni'] == '1' ) {?><div class="ribbon"><span><?=$diller['urun-box-text4']?></span></div><?php }?><?php } ?> <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '1') { ?><?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?><div class="cat-detail-products-box-cart-1"><?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $urunRow['stok'] > '0') { ?><?php if($urunRow['fiyat_goster'] == '1' ) {?><?php if($urunRow['siparis_islem'] == '0'  ) {?><?php if($varyantVarmi->rowCount()>'0'  ) {?><button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>"><i class="fa fa-shopping-basket"></i></button><?php }else { ?><form action="addtocart" method="post" ><input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>"><input name="token" type="hidden" value="<?=md5('homepageCallBack')?>"><input name="quantity" type="hidden" value="1"><button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>"><i class="fa fa-shopping-basket"></i></button></form><?php }?><?php }?><?php }?><?php if($urunRow['fiyat_goster'] == '2' ) {?><?php if($userSorgusu->rowCount()>'0'  ) {?><?php if($urunRow['siparis_islem'] == '0'  ) {?><?php if($varyantVarmi->rowCount()>'0'  ) {?><button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>"><i class="fa fa-shopping-basket"></i></button><?php }else { ?><form action="addtocart" method="post" ><input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>"><input name="token" type="hidden" value="<?=md5('homepageCallBack')?>"><input name="quantity" type="hidden" value="1"><button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>"><i class="fa fa-shopping-basket"></i></button></form><?php }?><?php }?><?php }?><?php }?><?php if($urunRow['fiyat_goster'] == '3' ) {?><?php if($uyegruplariCek->rowCount()>'0'  ) {?><?php if($urunRow['siparis_islem'] == '0'  ) {?><?php if($varyantVarmi->rowCount()>'0'  ) {?><button data-toggle="modal" data-target="#varyantModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>"><i class="fa fa-shopping-basket"></i></button><?php }else { ?><form action="addtocart" method="post" ><input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>"><input name="token" type="hidden" value="<?=md5('homepageCallBack')?>"><input name="quantity" type="hidden" value="1"><button name="addtocart" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text1']?>"><i class="fa fa-shopping-basket"></i></button></form><?php }?><?php }?><?php }?><?php }?><?php } ?> <?php if ($urunKutuRow['kutu_fav_button'] == '1') { ?><?php if($uyeayar['durum'] == '1' && $uyeayar['favori_alani'] == '1' ) {?><?php if($userSorgusu->rowCount()>'0'  ) {?><?php $favCek = $db->prepare("select * from urun_favori where urun_id=:urun_id ");$favCek->execute(array('urun_id' => $urunRow['id']));$urfav = $favCek->fetch(PDO::FETCH_ASSOC); ?><?php if($urfav['uye_id'] == $userCek['id']) {?><a href="#" class="tooltip-right product-fav-del" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" style="background-color: #f08183; color: #FFF;"><i class="fa fa-heart-o"></i></a><?php }else { ?><a href="#" class="tooltip-right product-fav-go" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>"><i class="fa fa-heart-o"></i></a><?php } ?><?php }else { ?><a href="" data-toggle="modal" data-target="#loginModal" class="tooltip-right" data-tooltip="<?=$diller['urun-box-text2']?>"><i class="fa fa-heart-o"></i></a><?php }?><?php }?><?php }?> <?php if ($urunKutuRow['kutu_compare_button'] == '1' && $odemeayar['urun_karsilastirma'] == '1') { ?><?php if(isset($_SESSION['compare_product'][$urunRow['id']] )) {?><a href="#" style="background-color: #f08183; color: #FFF;" data-code="<?php echo $urunRow['id']; ?>" class="tooltip-right product-compare-exit" data-tooltip="<?=$diller['urun-box-text8']?>"><i class="fa fa-random"></i></a><?php }else { ?><a href="#" class="tooltip-right product-compare" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>"><i class="fa fa-random"></i></a><?php }?><?php } ?></div><?php } ?><?php } ?><div class="firsat-product-box-img"><?php if ($urunKutuRow['kutu_kargo_goster'] == '1') { ?><?php if($odemeayar['kargo_sistemi'] == '1' ) {?><?php if($urunRow['kargo'] == '0' ) {?><div class="cat-detail-products-box-kargo"><i class="fa fa-truck"></i> <?=$diller['urun-box-text5']?></div><?php }?><?php }?><?php } ?><a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" ><?php if($ayar['lazy'] == '1' ) {?><img class="lazy" src="images/load.gif" data-original="images/product/<?=$urunRow['gorsel']?>" alt="<?php echo $urunRow['baslik'] ?>"><?php }else { ?><img src="images/product/<?=$urunRow['gorsel']?>" alt="<?=$urunRow['baslik']?>"><?php }?></a></div><div class="firsat-countdown-area"><div class='countdowns' data-date="<?=$firsatUrun['son_tarih']?>" data-time="<?=$firsatUrun['son_time']?>"></div></div><div class="cat-detail-products-box-caturunvitrin-info"><?php if ($urunKutuRow['kutu_star_rate'] == '1') { ?><?php if($uyeayar['durum'] == '0' ) {/* Üyelik Sistemi Devre Dışı ise Yöneticinin belirlediği yıldızları getir */ ?><div class="cat-detail-products-box-stars"><?php if($urunRow['star_rate'] == '0' ) {?><span class="pasif-span">★★★★★</span><?php }?> <?php if($urunRow['star_rate'] == '1' ) {?><span class="aktif-span">★</span><span class="pasif-span">★★★★</span><?php }?> <?php if($urunRow['star_rate'] == '2' ) {?><span class="aktif-span">★★</span><span class="pasif-span">★★★</span><?php }?> <?php if($urunRow['star_rate'] == '3' ) {?><span class="aktif-span">★★★</span><span class="pasif-span">★★</span><?php }?> <?php if($urunRow['star_rate'] == '4' ) {?><span class="aktif-span">★★★★</span><span class="pasif-span">★</span><?php }?> <?php if($urunRow['star_rate'] == '5' ) {?><span class="aktif-span">★★★★★</span><?php }?></div><?php }else {/* Üyelik var. Ürünün yorum durumunu kontrol et yorumlanabilir ise bilgileri çek yorumlanamaz ise yöneticinin belirlediğini ekrana yazdır */ ?><?php if($urunRow['yorum_durum'] == '0' ) {/* YORUM VE DEĞERLENDİRME YAPILAMAZ! */ ?><div class="cat-detail-products-box-stars"><?php if($urunRow['star_rate'] == '0' ) {?><span class="pasif-span">★★★★★</span><?php }?> <?php if($urunRow['star_rate'] == '1' ) {?><span class="aktif-span">★</span><span class="pasif-span">★★★★</span><?php }?> <?php if($urunRow['star_rate'] == '2' ) {?><span class="aktif-span">★★</span><span class="pasif-span">★★★</span><?php }?> <?php if($urunRow['star_rate'] == '3' ) {?><span class="aktif-span">★★★</span><span class="pasif-span">★★</span><?php }?> <?php if($urunRow['star_rate'] == '4' ) {?><span class="aktif-span">★★★★</span><span class="pasif-span">★</span><?php }?> <?php if($urunRow['star_rate'] == '5' ) {?><span class="aktif-span">★★★★★</span><?php }?></div><?php }else {/* Yorumlanabilir */ ?><div class="cat-detail-products-box-stars"><?php if($urun_comment_star == '0' ) {?><span class="pasif-span">★★★★★</span><?php }?> <?php if($urun_comment_star == '1' ) {?><span class="aktif-span">★</span><span class="pasif-span">★★★★</span><?php }?> <?php if($urun_comment_star == '2' ) {?><span class="aktif-span">★★</span><span class="pasif-span">★★★</span><?php }?> <?php if($urun_comment_star == '3' ) {?><span class="aktif-span">★★★</span><span class="pasif-span">★★</span><?php }?> <?php if($urun_comment_star == '4' ) {?><span class="aktif-span">★★★★</span><span class="pasif-span">★</span><?php }?> <?php if($urun_comment_star == '5' ) {?><span class="aktif-span">★★★★★</span><?php }?></div><?php }?><?php }?><?php } ?><div class="cat-detail-products-box-caturunvitrin-h"><a href="<?=$urunRow['seo_url']?>-P<?=$urunRow['id']?>" style="color: #<?=$urunKutuRow['kutu_yazi_renk'] ?>;"><?=$urunRow['baslik']?></a></div></div><?php if($urunRow['fiyat_goster'] == '1' && $urunRow['stok'] > '0' ) {?><div class="cat-detail-products-box-caturunvitrin-fiyat" ><div class="cat-detail-products-box-fiyat-out"><?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?><div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;"><?=kur_cekimi($urunRow['eski_fiyat'])?></div><?php }?><div class="cat-detail-products-box-fiyat-mevcut" style="color: #<?= $urunKutuRow['kutu_fiyat_renk'] ?>; "><?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?><?php if($box_fiyat == '0'  ) {?> <?=$diller['kategori-detay-text24']?><?php }else { ?><?php if($box_fiyat_uyari == '1'  ) {?><div class="cat-detail-products-box-special-out"><div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($urunRow['fiyat'])?>"><i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?></div></div><?php }?> <?=kur_cekimi($box_fiyat)?><?php }?><?php }else { ?><?php if($box_fiyat_uyari == '1'  ) {?><div class="cat-detail-products-box-special-out"><div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($urunRow['fiyat'])?>"><i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?></div></div><?php }?> <?=kur_cekimi($box_fiyat)?><?php }?></div></div><?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?><?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) { ?><div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">% <?=(int)$indirimorani?></div><?php }} ?></div><?php }?> <?php if($urunRow['fiyat_goster'] == '2' && $urunRow['stok'] > '0') {?><?php if($userSorgusu->rowCount()>'0'  ) {?><div class="cat-detail-products-box-caturunvitrin-fiyat" ><div class="cat-detail-products-box-fiyat-out"><?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?><div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;"><?=kur_cekimi($urunRow['eski_fiyat'])?></div><?php }?><div class="cat-detail-products-box-fiyat-mevcut" style="color: #<?= $urunKutuRow['kutu_fiyat_renk'] ?>; "><?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?><?php if($box_fiyat == '0'  ) {?> <?=$diller['kategori-detay-text24']?><?php }else { ?><?php if($box_fiyat_uyari == '1'  ) {?><div class="cat-detail-products-box-special-out"><div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($urunRow['fiyat'])?>"><i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?></div></div><?php }?> <?=kur_cekimi($box_fiyat)?><?php }?><?php }else { ?><?php if($box_fiyat_uyari == '1'  ) {?><div class="cat-detail-products-box-special-out"><div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($urunRow['fiyat'])?>"><i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?></div></div><?php }?> <?=kur_cekimi($box_fiyat)?><?php }?></div></div><?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?><?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) { ?><div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">% <?=(int)$indirimorani?></div><?php }} ?></div><?php }else { ?><?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?><div class="urun-box-special-area-caturunvitrin"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text22']?></div><?php }?><?php }?><?php }?> <?php if($urunRow['fiyat_goster'] == '3' && $urunRow['stok'] > '0' ) {?><?php if($uyegruplariCek->rowCount()>'0'  ) {?><div class="cat-detail-products-box-caturunvitrin-fiyat" ><div class="cat-detail-products-box-fiyat-out"><?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] > '0') {?><div class="cat-detail-products-box-fiyat-eski"style="color: #<?= $urunKutuRow['kutu_eskifiyat_renk'] ?>;"><?=kur_cekimi($urunRow['eski_fiyat'])?></div><?php }?><div class="cat-detail-products-box-fiyat-mevcut" style="color: #<?= $urunKutuRow['kutu_fiyat_renk'] ?>; "><?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?><?php if($box_fiyat == '0'  ) {?> <?=$diller['kategori-detay-text24']?><?php }else { ?><?php if($box_fiyat_uyari == '1'  ) {?><div class="cat-detail-products-box-special-out"><div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($urunRow['fiyat'])?>"><i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?></div></div><?php }?> <?=kur_cekimi($box_fiyat)?><?php }?><?php }else { ?><?php if($box_fiyat_uyari == '1'  ) {?><div class="cat-detail-products-box-special-out"><div class="cat-detail-products-box-special <?=$urunKutuRow['kutu_grupfiyat_button']?>" data-toggle="tooltip" data-placement="top" title="<?=$diller['urun-box-text10']?> : <?=kur_cekimi_nospan($urunRow['fiyat'])?>"><i class="fa fa-arrow-down"></i> <?=$diller['urun-box-text9']?></div></div><?php }?> <?=kur_cekimi($box_fiyat)?><?php }?></div></div><?php if ($urunKutuRow['kutu_indirim_goster'] == '1') { ?><?php if($urunRow['indirim'] == '1' && $urunRow['eski_fiyat'] >'0' ) { ?><div class="cat-detail-products-box-indirim tooltip-bottom" data-tooltip="<?=$diller['urun-box-text6']?>">% <?=(int)$indirimorani?></div><?php }} ?></div><?php }else { ?><?php if($odemeayar['fiyat_gosterim_uyari'] == '1' ) {?><div class="urun-box-special-area-caturunvitrin"><i class="fa fa-lock"></i> <?=$diller['kategori-detay-text23']?></div><?php }?><?php }?><?php }?> <?php if($urunRow['stok'] <= '0' ) {?><div class="cat-detail-products-box-caturunvitrin-fiyat" ><div class="cat-detail-products-box-fiyat-out button-red button-1x" style="width: 100%; text-align: center;"><?=$diller['urun-detay-stok-durum-yok']?></div></div><?php }?> <?php if ($urunKutuRow['kutu_aksiyon_tip'] == '2') { ?><?php if ($urunKutuRow['kutu_sepet_button'] == '1' || $urunKutuRow['kutu_fav_button'] == '1' || $urunKutuRow['kutu_compare_button'] == '1') { ?><div class="cat-detail-products-box-cart-2"><?php if ($urunKutuRow['kutu_sepet_button'] == '1' && $urunRow['stok'] > '0') { ?><?php if($urunRow['fiyat_goster'] == '1' ) {?><?php if($urunRow['siparis_islem'] == '0'  ) {?><?php if($varyantVarmi->rowCount()>'0'  ) {?><button data-toggle="modal" data-target="#varyantModal"><?=$diller['urun-box-text1']?></button><?php }else { ?><form action="addtocart" method="post" ><input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>"><input name="token" type="hidden" value="<?=md5('homepageCallBack')?>"><input name="quantity" type="hidden" value="1"><button name="addtocart" ><?=$diller['urun-box-text1']?></button></form><?php }} ?><?php } ?><?php if($urunRow['fiyat_goster'] == '2' ) {?><?php if($userSorgusu->rowCount()>'0' ) {?><?php if($urunRow['siparis_islem'] == '0'  ) {?><?php if($varyantVarmi->rowCount()>'0'  ) {?><button data-toggle="modal" data-target="#varyantModal"><?=$diller['urun-box-text1']?></button><?php }else { ?><form action="addtocart" method="post" ><input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>"><input name="token" type="hidden" value="<?=md5('homepageCallBack')?>"><input name="quantity" type="hidden" value="1"><button name="addtocart" ><?=$diller['urun-box-text1']?></button></form><?php } ?><?php }?><?php }?><?php } ?><?php if($urunRow['fiyat_goster'] == '3' ) {?><?php if($uyegruplariCek->rowCount()>'0' ) {?><?php if($urunRow['siparis_islem'] == '0'  ) {?><?php if($varyantVarmi->rowCount()>'0'  ) {?><button data-toggle="modal" data-target="#varyantModal"><?=$diller['urun-box-text1']?></button><?php }else { ?><form action="addtocart" method="post" ><input name="product_code" type="hidden" value="<?php echo $urunRow["id"]; ?>"><input name="token" type="hidden" value="<?=md5('homepageCallBack')?>"><input name="quantity" type="hidden" value="1"><button name="addtocart" ><?=$diller['urun-box-text1']?></button></form><?php } ?><?php } ?><?php } ?><?php } ?><?php } ?> <?php if ($urunKutuRow['kutu_fav_button'] == '1') { ?><?php if($uyeayar['durum'] == '1' && $uyeayar['favori_alani'] == '1' ) {?><?php if($userSorgusu->rowCount()>'0'  ) {?><?php $favCek = $db->prepare("select * from urun_favori where urun_id=:urun_id ");$favCek->execute(array('urun_id' => $urunRow['id']));$urfav = $favCek->fetch(PDO::FETCH_ASSOC); ?><?php if($urfav['uye_id'] == $userCek['id']) {?><a href="#" class="tooltip-bottom product-fav-del" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text7']?>" ><i class="fa fa-heart"></i></a><?php }else { ?><a href="#" class="tooltip-bottom product-fav-go compare-href" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text2']?>"><i class="fa fa-heart-o"></i></a><?php }?><?php } else { ?><a href="" data-toggle="modal" data-target="#loginModal" class="compare-href tooltip-bottom" data-tooltip="<?=$diller['urun-box-text2']?>"><i class="fa fa-heart-o"></i></a><?php }?><?php } ?><?php } ?> <?php if ($urunKutuRow['kutu_compare_button'] == '1' && $odemeayar['urun_karsilastirma'] == '1') { ?><?php if(isset($_SESSION['compare_product'][$urunRow['id']] )) {?><a href="#" class=" tooltip-bottom product-compare-exit" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text8']?>"><i class="fa fa-random"></i></a><?php }else { ?><a href="#" class="compare-href tooltip-bottom product-compare" data-code="<?php echo $urunRow['id']; ?>" data-tooltip="<?=$diller['urun-box-text3']?>"><i class="fa fa-random"></i></a><?php }?><?php } ?></div><?php } ?><?php } ?></div></div><?php }?><?php }?><?php }?></div><div class="swiper-button-next"></div><div class="swiper-button-prev"></div></div><?php }?></div></div><?php if($firsatRow['bg_tip'] == '0'  ) {?><?php if($firsatRow['bg_dark'] == '1'  ) {?><!-- Slider Karartma Var ise !--><div style="background: rgba(0,0,0,0.6); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div><!-- Slider Karartma Var ise !--><?php }?><?php }?></div>
<script>
    (function ( $ ) {
        function pad(n) {
            return (n < 10) ? ("0" + n) : n;
        }

        $.fn.showclock = function() {

            var currentDate=new Date();
            var fieldDate=$(this).data('date').split('-');
            var fieldTime=[0,0];
            if($(this).data('time')!=undefined)
                fieldTime=$(this).data('time').split(':');
            var futureDate=new Date(fieldDate[0],fieldDate[1]-1,fieldDate[2],fieldTime[0],fieldTime[1]);
            var seconds=futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

            if(seconds<=0 || isNaN(seconds)){
                this.hide();
                return this;
            }

            var days=Math.floor(seconds/86400);
            seconds=seconds%86400;

            var hours=Math.floor(seconds/3600);
            seconds=seconds%3600;

            var minutes=Math.floor(seconds/60);
            seconds=Math.floor(seconds%60);

            var html="";

            if(days!=0){
                html+="<div class='countdown-container days'>"
                html+="<span class='countdown-value days-bottom'>"+pad(days)+"</span>";
                html+="<span class='countdown-heading days-top'><?=$diller['bakim-mod-text11']?></span>";
                html+="</div>";
            }

            html+="<div class='countdown-container hours'>"
            html+="<span class='countdown-value hours-bottom'>"+pad(hours)+"</span>";
            html+="<span class='countdown-heading hours-top'><?=$diller['bakim-mod-text12']?></span>";
            html+="</div>";

            html+="<div class='countdown-container minutes'>"
            html+="<span class='countdown-value minutes-bottom'>"+pad(minutes)+"</span>";
            html+="<span class='countdown-heading minutes-top'><?=$diller['bakim-mod-text13']?></span>";
            html+="</div>";

            html+="<div class='countdown-container seconds'>"
            html+="<span class='countdown-value seconds-bottom'>"+pad(seconds)+"</span>";
            html+="<span class='countdown-heading seconds-top'><?=$diller['bakim-mod-text14']?></span>";
            html+="</div>";

            this.html(html);
        };

        $.fn.countdown = function() {
            var el=$(this);
            el.showclock();
            setInterval(function(){
                el.showclock();
            },1000);

        }

    }(jQuery));

    jQuery(document).ready(function(){
        if(jQuery(".countdowns").length>0){
            jQuery(".countdowns").each(function(){
                jQuery(this).countdown();
            })

        }
    })
</script>
