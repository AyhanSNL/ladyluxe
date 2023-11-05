<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;
unset($_SESSION['form_temp']);?>
<?php
$sozlesmeCek = $db->prepare("select * from htmlsayfa_sozlesmeler where tur=:tur and dil=:dil  ");
$sozlesmeCek->execute(array(
        'tur' => '1',
        'dil' => $_SESSION['dil']
));
$sozlesme = $sozlesmeCek->fetch(PDO::FETCH_ASSOC);

$uyeAdres = $db->prepare("select * from uyeler_adres where uye_id=:uye_id");
$uyeAdres->execute(array(
        'uye_id' => $userCek['id']
));

?>
<form action="paymentstep" method="post">
    <div class="teslimat-page-main-div" style="background-color: #<?=$odemeayar['alisveris_arkaplan']?>;">
        <?php if($pagehead['durum'] == '1' ) {?>
            <div class="page-banner-main" >
                <div class="page-banner-in-text">
                    <div class="page-banner-h <?=$pagehead['baslik_space']?>">
                        <?=$diller['teslimat-sayfa-baslik']?>
                    </div>
                    <div class="page-banner-links ">
                        <a href="<?=$ayar['site_url']?>"><i class="fa fa-home"></i> <?=$diller['sayfa-banner-anasayfa']?></a>
                        <span>/</span>
                        <a><?=$diller['teslimat-sayfa-baslik']?></a>
                    </div>
                </div>
                <?php if($pagehead['bg_tip'] == '0'  ) {?>
                    <?php if($pagehead['bg_dark'] == '1'  ) { ?>
                        <!-- Karartma Var ise !-->
                        <div style="background: rgba(0,0,0,0.3); width: 100%; height: 100%; position: absolute; top:0; left:0; z-index: 1"></div>
                        <!-- Karartma Var ise !-->
                        <?php
                    }}
                ?>
            </div>
        <?php }?>
    <div class="teslimat-page-main">

        <style>
            .teslimat-bilgileri-adres-box.custom-control-label::before{
                display: none !important;
                width: 0 !important;
            }
        </style>

        <!-- Teslimat için kişisel veya kurumsal bilgiler !-->
        <div class="teslimat-bilgileri-div">
            <div class="teslimat-bilgileri-uye-adres-main">
                <div style="width: 100%; overflow: hidden "><div style=" width: 102%; overflow: hidden; display: flex; justify-content: flex-start; flex-wrap: wrap;  ">
                <div class="teslimat-bilgi-baslik">
                    <?=$diller['teslimat-sayfa-baslik']?>
                </div>
            <?php if($uyeAdres->rowCount() > '0'  ) {?>
            <!-- Adresler !-->
                <?php
                /* adresVarsayilan Sorgusu */
                $uyeAdresVarsayilansorgu = $db->prepare("select * from uyeler_adres where uye_id=:uye_id and secili=:secili");
                $uyeAdresVarsayilansorgu->execute(array(
                    'uye_id' => $userCek['id'],
                    'secili' => '1'
                ));
                /*  <========SON=========>>> adresVarsayilan Sorgusu SON */
                ?>
                    <?php foreach ($uyeAdres as $adres) {
                    $ulkeCek = $db->prepare("select * from ulkeler where 3_iso=:3_iso ");
                    $ulkeCek->execute(array(
                        '3_iso' => $adres['ulke']
                    ));
                    $ulkeRow = $ulkeCek->fetch(PDO::FETCH_ASSOC);


                    ?>
                    <div class="teslimat-bilgileri-adres-box " >
                        <div class="custom-control custom-radio">
                            <input id="<?=$adres['adres_id']?>" type="radio" name="adres_no" value="<?=$adres['adres_id']?>" class="custom-control-input" <?php if($adres['secili'] == '1' ) { ?>checked<?php }?> <?php if($uyeAdresVarsayilansorgu->rowCount()<='0'  ) { ?>checked<?php }?> required>
                            <label class="custom-control-label" for="<?=$adres['adres_id']?>"  >
                                <div class="teslimat-bilgileri-adres-box-secili"><i class="fa fa-check"></i> <?=$diller['teslimat-uye-text-3']?></div>
                                <div class="teslimat-bilgileri-adres-box-2">
                                    <div class="user_subpage_address_box_name">
                                        <?=$adres['baslik']?>
                                    </div>
                                    <div class="user_subpage_address_box_user">
                                        <?=$adres['isim']?> <?=$adres['soyisim']?>
                                    </div>
                                    <div class="user_subpage_address_box_content">
                                        <?=$adres['adresbilgisi']?>
                                        <br>
                                        <?=$adres['ilce']?> / <?=$adres['sehir']?>
                                        <br>
                                        <strong><?=$ulkeRow['baslik']?></strong>
                                    </div>
                                    <div class="user_subpage_address_box_phone">
                                        <?=$adres['telefon']?> - <?=$adres['eposta']?>
                                    </div>
                                    <?php if($odemeayar['faturasiz_teslimat'] == '0'  ) {?>
                                        <div class="user_subpage_address_box_type">
                                            <?php if($adres['fatura_turu'] == '1' ) {?>
                                                <?=$diller['users-panel-text82']?>
                                            <?php }?>
                                            <?php if($adres['fatura_turu'] == '2' ) {?>
                                                <?=$diller['users-panel-text83']?>
                                            <?php }?>
                                        </div>
                                    <?php }?>
                                    <div class="user_subpage_address_box_buttons">
                                        <a href="hesabim/adres-duzenle/<?=$adres['adres_id']?>/" class="button-orange button-1x">
                                            <?=$diller['users-panel-text84']?>
                                        </a>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <?php }?>
                <?php
                $_SESSION['teslimat_adres_url'] = 'cart'
                ?>
                <a href="hesabim/yeni-adres-ekle/" class="teslimat-bilgileri-uye-adres-yok-box tsl-ad-2">
                    <div>
                        <div class="teslimat-bilgileri-uye-adres-yok-box-icon">
                            <i class="las la-plus"></i>
                        </div>
                        <?=$diller['teslimat-uye-text-2']?>
                    </div>
                </a>
            <!--  <========SON=========>>> Adresler SON !-->
            <?php }else { ?>
                <!-- Adres yok !-->
                    <div class="teslimat-bilgileri-uye-adres-yok">
                        <i class="fa fa-exclamation-triangle"></i> <?=$diller['teslimat-uye-text-1']?>
                    </div>
                    <?php
                    $_SESSION['teslimat_adres_url'] = 'account'
                    ?>
                    <a href="hesabim/yeni-adres-ekle/" class="teslimat-bilgileri-uye-adres-yok-box">
                        <div>
                           <div class="teslimat-bilgileri-uye-adres-yok-box-icon">
                               <i class="las la-plus"></i>
                           </div>
                            <?=$diller['teslimat-uye-text-2']?>
                        </div>
                    </a>
                <!--  <========SON=========>>> Adres yok SON !-->
            <?php }?>
                </div></div>
            </div>
            <div class="teslimat-bilgileri-sol-kutular">
                <div class="teslimat-bilgi-baslik">
                    <?=$diller['teslimat-sayfa-form-siparis-not']?>
                </div>
                <div class="teslimat-form-area">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <textarea name="siparis_notu" id="siparis_notu" class="form-control" rows="3" ></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Teslimat için kişisel veya kurumsal bilgiler SON !-->


        <!-- Ödeme türü ve sepet özeti alanı !-->
        <div class="teslimat-sag-taraf">


            <?php if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'   ) {?>
                <div class="teslimat-odeme-secimi odemeyi-sec">
                    <div class="teslimat-odeme-main-h">
                        <i class="las la-gift" style="font-size: 21px ;"></i><?=$diller['teslimat-sayfa-form-odeme-ucretsiz-baslik']?>
                    </div>

                    <?php if($odemeayar['ucretsiz_alisveris'] == '1' ) {?>
                        <input type="hidden" name="odeme_tipi" value="freeShip" >
                        <div class="teslimat-odeme-main-box" >
                            <div class="font-16 ">
                                <label for="1"><?=$diller['teslimat-sayfa-form-odeme-ucretsiz-aciklama']?></label>
                            </div>
                        </div>
                    <?php }else { ?>
                        <div class="teslimat-odeme-main-box" >
                            <input type="hidden" name="odeme_tipi" value="spot" >
                            <div class="font-14 " style="font-weight: 600;">
                                <label for="1"><?=$diller['teslimat-sayfa-form-odeme-ucretsiz-aciklama-no']?></label>
                            </div>
                        </div>
                    <?php }?>


                </div>

            <?php }else { ?>
                <div class="teslimat-odeme-secimi" >
                    <div class="teslimat-odeme-main-h">
                        <i class="ion-loop" style="font-size: 21px ;"></i><?=$diller['teslimat-sayfa-form-odeme-yonteminiz']?>
                    </div>
                    <?php if($odemeayar['kredi_kart'] == '1' ) {?>
                        <div class="teslimat-odeme-main-box">
                            <div class="rdio rdio-primary font-14 ">
                                <input name="odeme_tipi" class="change_radio" value="1" id="1" type="radio" <?php if($odemeayar['kredi_kart'] == '1' ) { ?>checked<?php }?>>
                                <label for="1"><div class="ml-1"><?=$diller['teslimat-sayfa-form-kredi-kart']?></div></label>
                            </div>
                        </div>
                    <?php }?>
                    <?php if($odemeayar['havale_eft'] == '1' ) {?>
                        <div class="teslimat-odeme-main-box">
                            <div class="rdio rdio-primary font-14 ">
                                <input name="odeme_tipi" class="change_radio" value="2" id="2" type="radio" <?php if($odemeayar['kredi_kart'] == '0' ) { ?>checked<?php } ?> >
                                <label for="2"><div class="ml-1"><?=$diller['teslimat-sayfa-form-banka']?></div></label>
                            </div>
                        </div>
                    <?php }?>
                    <?php if(($aratoplam+$kdvtoplami) >= $odemeayar['kapida_odeme_limit'] ) {?>
                        <?php if($odemeayar['kapida_odeme_kart'] == '1' ) {?>
                            <div class="teslimat-odeme-main-box" style="display: flex; align-items: center; justify-content: space-between;">
                                <div class="rdio rdio-primary font-14 ">
                                    <input name="odeme_tipi" class="change_radio" value="3" id="3" type="radio" <?php if($odemeayar['kredi_kart'] == '0' && $odemeayar['havale_eft'] == '0' ) { ?>checked<?php } ?>>
                                    <label for="3"><div class="ml-1">
                                        <?=$diller['teslimat-sayfa-form-kapida-odeme-1']?>
                                        <?php if($odemeayar['kapida_odeme_kart_tutar'] >'0') {?>
                                            <span style=" font-size: 13px ; background: #f8f8f8; border: 1px solid #ebebeb; font-style: italic; display: inline-block; margin-left: 5px; padding: 0 5px; font-weight: 600;"> +
                                            <?=kur_cekimi($odemeayar['kapida_odeme_kart_tutar'])?>
                                              </span>
                                        <?php } ?>
                                        </div></label>
                                </div>
                                <div>
                                    <?php if($odemeayar['kapida_odeme_kart_tutar'] >'0') {?>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['teslimat-sayfa-form-kapida-odeme-aciklama']?>"></i>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }?>

                        <?php if($odemeayar['kapida_odeme_nakit'] == '1' ) {?>
                            <div class="teslimat-odeme-main-box" style="display: flex; align-items: center; justify-content: space-between;">
                                <div class="rdio rdio-primary font-14 ">
                                    <input name="odeme_tipi" class="change_radio" value="4" id="4" type="radio" <?php if($odemeayar['kredi_kart'] == '0' && $odemeayar['havale_eft'] == '0' && $odemeayar['kapida_odeme_kart'] == '0' ) { ?>checked<?php } ?> >
                                    <label for="4"><div class="ml-1">
                                        <?=$diller['teslimat-sayfa-form-kapida-odeme-2']?>
                                        <?php if($odemeayar['kapida_odeme_nakit_tutar'] >'0') {?>
                                            <span style=" font-size: 13px ; background: #f8f8f8; border: 1px solid #ebebeb; font-style: italic; display: inline-block; margin-left: 5px;
                             padding: 0 5px; font-weight: 600;">
                                 +
                                <?=kur_cekimi($odemeayar['kapida_odeme_nakit_tutar'])?>
                            </span>
                                        <?php }?>
                                        </div> </label>
                                </div>
                                <div>
                                    <?php if($odemeayar['kapida_odeme_nakit_tutar'] >'0') {?>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['teslimat-sayfa-form-kapida-odeme-aciklama']?>"></i>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }?>
                    <?php }?>
                    <?php if($odemeayar['kapida_odeme_kart'] == '1' || $odemeayar['kapida_odeme_nakit'] == '1' ) {?>
                        <?php if(($aratoplam+$kdvtoplami) < $odemeayar['kapida_odeme_limit'] ) {?>
                            <div class="teslimat-sepet-ozet-main border border-danger mt-3 mb-0 font-14 alert-danger ">
                                <?=$diller['teslimat-odeme-uyari-limit']?>
                                <br><br>
                                <?=$diller['teslimat-odeme-uyari-limit-2']?> : <strong><?=kur_cekimi($odemeayar['kapida_odeme_limit'])?></strong>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>

                <?php if($odemeayar['kredi_kart'] == '1' ) {?>
                    <div class="radio-content" data-radio="1" style="display:none">
                        <div class="teslimat-sepet-ozet-main">
                            <div class="teslimat-sepet-ozet-main-h">
                                <i class="fa fa-credit-card"></i>  <?=$diller['teslimat-sayfa-form-kredi-kart']?>
                            </div>
                            <?php if($odemeayar['kredi_kart_doviz_durum'] == '0' ) {?>
                                <?php if($secilikur['kod'] != 'TRY' ) {?>
                                    <div class="alert alert-info" style="font-size: 13px ; border-radius: 0">
                                        <?=$diller['teslimat-doviz-uyari']?>
                                    </div>
                                <?php }?>
                            <?php }?>
                            <?php if($odemeayar['kredi_kart_doviz_durum'] == '1' ) {?>
                                <?php if($odemeayar['pos_tur'] != 'iyzico'  ) {?>
                                    <?php if($secilikur['kod'] != 'TRY' ) {?>
                                        <div class="alert alert-info" style="font-size: 13px ; border-radius: 0">
                                            <?=$diller['teslimat-doviz-uyari']?>
                                        </div>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                            <div class="teslimat-sepet-ozet-main-box">
                                <div class="font-15"><?=$diller['sepet-ozet-ara-toplam']?> </div>
                                <div class="font-17 font-bold">
                                    <?=kur_cekimi($aratoplam)?>
                                </div>
                            </div>
                            <?php if($sepette_ek_indirim>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ek-indirim']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($sepette_ek_indirim)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($ilk_sip_indirim>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ilk-siparis-indirim']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($ilk_sip_indirim)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($grubindirimi>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-size-ozel-indirim']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($grubindirimi)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($indirimtutar > '0' ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-kupon-indirim-tutar']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($indirimtutar)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($kdvtoplami>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-kdv']?></div>
                                    <div class="font-17 font-bold">
                                        <?=kur_cekimi($kdvtoplami)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-kargo-tutar']?> </div>
                                    <div class="font-17 font-bold">
                                        <?php if($kargotoplami>'0'  ) {?>
                                            <?=kur_cekimi($kargotoplami)?>
                                        <?php }else { ?>
                                            <span style="font-size: 12px ;"><?=$diller['urunler-ucretsiz-kargo-yazisi']?></span>
                                        <?php }?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="teslimat-sepet-ozet-main-box">
                                <div class="font-18"><?=$diller['sepet-ozet-odenecek-tutar']?> </div>
                                <div class="font-20 font-bold">
                                    <?=kur_cekimi((((($aratoplam+$kargotoplami+$kdvtoplami)-$sepette_ek_indirim)-$indirimtutar)-$ilk_sip_indirim)-$grubindirimi)?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } ?>

                <?php if($odemeayar['havale_eft'] == '1' ) {?>
                    <div class="radio-content" data-radio="2" style="display:none">
                        <div class="teslimat-sepet-ozet-main">
                            <div class="teslimat-sepet-ozet-main-h">
                                <i class="fa fa-bank"></i>  <?=$diller['teslimat-sayfa-form-banka']?>
                            </div>
                            <?php if($odemeayar['havale_doviz_durum'] == '0' ) {?>
                                <?php if($secilikur['kod'] != 'TRY' ) {?>
                                    <div class="alert alert-info" style="font-size: 13px ; border-radius: 0">
                                        <?=$diller['teslimat-doviz-uyari-2']?>
                                    </div>
                                <?php }?>
                            <?php }?>
                            <div class="teslimat-sepet-ozet-main-box">
                                <div class="font-15"><?=$diller['sepet-ozet-ara-toplam']?> </div>
                                <div class="font-17 font-bold">
                                    <?=kur_cekimi($havale_aratoplam)?>
                                </div>
                            </div>
                            <?php if($sepette_ek_indirim_havale>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ek-indirim']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($sepette_ek_indirim_havale)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($ilk_sip_indirim_havale>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ilk-siparis-indirim']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($ilk_sip_indirim_havale)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($grubindirimi_havale > '0' ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-size-ozel-indirim']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($grubindirimi_havale)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($havale_indirimtutar > '0' ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-kupon-indirim-tutar']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($havale_indirimtutar)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($kdvtoplami>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-kdv']?></div>
                                    <div class="font-17 font-bold">
                                        <?=kur_cekimi($havale_kdvtoplam)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-kargo-tutar']?> </div>
                                    <div class="font-17 font-bold">
                                        <?php if($havalekargo_toplami>'0'  ) {?>
                                            <?=kur_cekimi($havalekargo_toplami)?>
                                        <?php }else { ?>
                                            <span style="font-size: 12px ;"><?=$diller['urunler-ucretsiz-kargo-yazisi']?></span>
                                        <?php }?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="teslimat-sepet-ozet-main-box">
                                <div class="font-18"><?=$diller['sepet-ozet-odenecek-tutar']?> </div>
                                <div class="font-20 font-bold">
                                    <?=kur_cekimi(((($havale_odenecek_tutar-$sepette_ek_indirim_havale)-$havale_indirimtutar)-$ilk_sip_indirim_havale)-$grubindirimi_havale)?>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } ?>

                <?php if(($aratoplam+$kdvtoplami) >= $odemeayar['kapida_odeme_limit'] ) {?>
                    <?php if($odemeayar['kapida_odeme_kart'] == '1' ) {?>
                        <div class="radio-content" data-radio="3" style="display:none">
                            <div class="teslimat-sepet-ozet-main">
                                <div class="teslimat-sepet-ozet-main-h">
                                    <i class="fa fa-truck"></i> <?=$diller['teslimat-sayfa-form-kapida-odeme-1']?>
                                </div>
                                <?php if($odemeayar['kapida_odeme_doviz_durum'] == '0' ) {?>
                                    <?php if($secilikur['kod'] != 'TRY' ) {?>
                                        <div class="alert alert-info" style="font-size: 13px ; border-radius: 0">
                                            <?=$diller['teslimat-doviz-uyari-3']?>
                                        </div>
                                    <?php }?>
                                <?php }?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-ara-toplam']?> </div>
                                    <div class="font-17 font-bold">
                                        <?=kur_cekimi($aratoplam)?>
                                    </div>
                                </div>
                                <?php if($sepette_ek_indirim>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ek-indirim']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($sepette_ek_indirim)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($ilk_sip_indirim>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ilk-siparis-indirim']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($ilk_sip_indirim)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($grubindirimi>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-size-ozel-indirim']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($grubindirimi)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($indirimtutar > '0' ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ozet-kupon-indirim-tutar']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($indirimtutar)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($kdvtoplami>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ozet-kdv']?></div>
                                        <div class="font-17 font-bold">
                                            <?=kur_cekimi($kdvtoplami)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ozet-kargo-tutar']?> </div>
                                        <div class="font-17 font-bold">
                                            <?php if($kargotoplami>'0'  ) {?>
                                                <?=kur_cekimi($kargotoplami)?>
                                            <?php }else { ?>
                                                <span style="font-size: 12px ;"><?=$diller['urunler-ucretsiz-kargo-yazisi']?></span>
                                            <?php }?>
                                        </div>
                                    </div>
                                <?php } ?>


                                <?php if($odemeayar['kapida_odeme_kart_tutar'] >'0') {
                                    $kapida_kart = $odemeayar['kapida_odeme_kart_tutar'];
                                    ?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['teslimat-sayfa-form-kapida-odeme-bedeli']?></div>
                                        <div class="font-17 font-bold">
                                            <?=kur_cekimi($odemeayar['kapida_odeme_kart_tutar'])?>
                                        </div>
                                    </div>
                                <?php }else { ?>
                                    <?php
                                    $kapida_kart = 0;
                                    ?>
                                <?php }?>


                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-18"><?=$diller['sepet-ozet-odenecek-tutar']?> </div>
                                    <div class="font-20 font-bold">
                                        <?=kur_cekimi((((($aratoplam+$kargotoplami+$kdvtoplami+$kapida_kart)-$sepette_ek_indirim)-$indirimtutar)-$ilk_sip_indirim)-$grubindirimi)?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                    <?php if($odemeayar['kapida_odeme_nakit'] == '1' ) {?>
                        <div class="radio-content" data-radio="4" style="display:none">
                            <div class="teslimat-sepet-ozet-main">
                                <div class="teslimat-sepet-ozet-main-h">
                                    <i class="fa fa-truck"></i> <?=$diller['teslimat-sayfa-form-kapida-odeme-2']?>
                                </div>
                                <?php if($odemeayar['kapida_odeme_doviz_durum'] == '0' ) {?>
                                    <?php if($secilikur['kod'] != 'TRY' ) {?>
                                        <div class="alert alert-info" style="font-size: 13px ; border-radius: 0">
                                            <?=$diller['teslimat-doviz-uyari-3']?>
                                        </div>
                                    <?php }?>
                                <?php }?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-ara-toplam']?> </div>
                                    <div class="font-17 font-bold">
                                        <?=kur_cekimi($aratoplam)?>
                                    </div>
                                </div>
                                <?php if($sepette_ek_indirim>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ek-indirim']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($sepette_ek_indirim)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($ilk_sip_indirim>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ilk-siparis-indirim']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($ilk_sip_indirim)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($grubindirimi>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-size-ozel-indirim']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($grubindirimi)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($indirimtutar > '0' ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ozet-kupon-indirim-tutar']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($indirimtutar)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($kdvtoplami>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ozet-kdv']?></div>
                                        <div class="font-17 font-bold">
                                            <?=kur_cekimi($kdvtoplami)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ozet-kargo-tutar']?> </div>
                                        <div class="font-17 font-bold">
                                            <?php if($kargotoplami>'0'  ) {?>
                                                <?=kur_cekimi($kargotoplami)?>
                                            <?php }else { ?>
                                                <span style="font-size: 12px ;"><?=$diller['urunler-ucretsiz-kargo-yazisi']?></span>
                                            <?php }?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <?php if($odemeayar['kapida_odeme_nakit_tutar'] >'0') {
                                    $kapida_nakit = $odemeayar['kapida_odeme_nakit_tutar'];
                                    ?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['teslimat-sayfa-form-kapida-odeme-bedeli']?></div>
                                        <div class="font-17 font-bold">
                                            <?=kur_cekimi($kapida_nakit)?>
                                        </div>
                                    </div>
                                <?php }else { ?>
                                    <?php
                                    $kapida_nakit = 0;
                                    ?>
                                <?php }?>

                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-18"><?=$diller['sepet-ozet-odenecek-tutar']?> </div>
                                    <div class="font-20 font-bold">
                                        <?=kur_cekimi((((($aratoplam+$kargotoplami+$kdvtoplami+$kapida_nakit)-$sepette_ek_indirim)-$indirimtutar)-$ilk_sip_indirim)-$grubindirimi)?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                <?php }?>
            <?php }?>


            <?php if($odemeayar['kredi_kart'] == '1' || $odemeayar['havale_eft'] == '1') {?>
                <?php if($sozlesmeCek->rowCount()>'0'  ) {?>
                    <?php if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {?>
                        <?php if($odemeayar['ucretsiz_alisveris'] == '1'  ) {?>
                            <div class="teslimat-onaybutton-main">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="sozlesme_onayi" value="1" class="custom-control-input" id="sozlesmeOnay"  checked>
                                    <label class="custom-control-label" for="sozlesmeOnay" style="font-size: 14px ; ">
                                        <a  data-toggle="modal" data-target="#sozlesmeModal" style="color: #333; cursor: pointer ">
                                            <strong style="text-decoration: underline;"><?=$diller['teslimat-sayfa-form-onay-text1']?></strong></a>
                                        <?=$diller['teslimat-sayfa-form-onay-text2']?>
                                    </label>
                                </div>
                            </div>
                            <!-- Sözleşme MODAL -->
                            <div class="modal " id="sozlesmeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
                                    <div class="modal-content  shadow-lg">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="exampleModalCenterTitle" style="font-weight: bold;">
                                                <?=$sozlesme['baslik']?>
                                            </h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="font-size: 14px ; line-height: normal !important;" >
                                            <?=$sozlesme['icerik']?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="button-black button-1x" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sözleşme MODAL -->
                        <?php }?>
                    <?php }else { ?>
                        <div class="teslimat-onaybutton-main">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="sozlesme_onayi" value="1" class="custom-control-input" id="sozlesmeOnay"  checked>
                                <label class="custom-control-label" for="sozlesmeOnay" style="font-size: 14px ; ">
                                    <a  data-toggle="modal" data-target="#sozlesmeModal" style="color: #333; cursor: pointer ">
                                        <strong style="text-decoration: underline;"><?=$diller['teslimat-sayfa-form-onay-text1']?></strong></a>
                                    <?=$diller['teslimat-sayfa-form-onay-text2']?>
                                </label>
                            </div>
                        </div>
                        <!-- Sözleşme MODAL -->
                        <div class="modal " id="sozlesmeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
                                <div class="modal-content  shadow-lg">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalCenterTitle" style="font-weight: bold;">
                                            <?=$sozlesme['baslik']?>
                                        </h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="font-size: 14px ; line-height: normal !important;" >
                                        <?=$sozlesme['icerik']?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button-black button-1x" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sözleşme MODAL -->
                    <?php }?>
                <?php } ?>
                <?php if($uyeAdres->rowCount() > '0'  ) {?>
                    <?php if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {?>
                        <?php if($odemeayar['ucretsiz_alisveris'] == '1'  ) {?>
                            <button type="submit" id="shopButton" name="paymentValueGo" class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; font-size: 18px ;  ">
                                <?=$diller['teslimat-sayfa-form-button']?>
                            </button>
                        <?php }?>
                    <?php }else { ?>
                        <button type="submit" id="shopButton" name="paymentValueGo" class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; font-size: 18px ;  ">
                            <?=$diller['teslimat-sayfa-form-button']?>
                        </button>
                    <?php }?>
                <?php }else { ?>
                    <?php if(($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar <='0'  ) {?>
                        <?php if($odemeayar['ucretsiz_alisveris'] == '1'  ) {?>
                            <a  href="" data-toggle="modal" data-target="#adresnomodal"  class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; font-size: 18px ; text-align: center;  ">
                                <?=$diller['teslimat-sayfa-form-button']?>
                            </a>

                            <!-- adres yok modalı !-->
                            <div class="modal " id="adresnomodal" data-backdrop="static" >
                                <div class="modal-dialog modal-dialog-centered modal-sm ">
                                    <div class="modal-content shadow-lg">
                                        <div style="position: absolute; z-index: 9; right: 10px">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none; color: #FFF;">
                                                <i class="ion-ios-close-empty"></i>
                                            </button>
                                        </div><div class="teslimat-bilgi-hata-main-text-h">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['teslimat-form-hata-baslik']?>
                                        </div>
                                        <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">

                                            <?=$diller['teslimat-uye-text-1']?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> adres yok modalı SON !-->
                        <?php }?>
                    <?php }else { ?>
                        <a  href="" data-toggle="modal" data-target="#adresnomodal"  class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; font-size: 18px ; text-align: center;  ">
                            <?=$diller['teslimat-sayfa-form-button']?>
                        </a>

                        <!-- adres yok modalı !-->
                        <div class="modal " id="adresnomodal" data-backdrop="static" >
                            <div class="modal-dialog modal-dialog-centered modal-sm ">
                                <div class="modal-content shadow-lg">
                                    <div style="position: absolute; z-index: 9; right: 10px">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none; color: #FFF;">
                                            <i class="ion-ios-close-empty"></i>
                                        </button>
                                    </div><div class="teslimat-bilgi-hata-main-text-h">
                                        <i class="fa fa-exclamation-triangle"></i> <?=$diller['teslimat-form-hata-baslik']?>
                                    </div>
                                    <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">

                                        <?=$diller['teslimat-uye-text-1']?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--  <========SON=========>>> adres yok modalı SON !-->
                    <?php }?>
                <?php }?>
            <?php }else { ?>
                <?php if($odemeayar['kapida_odeme_nakit'] == '1' || $odemeayar['kapida_odeme_kart'] == '1') {?>
                    <?php if(($aratoplam+$kdvtoplami) >= $odemeayar['kapida_odeme_limit'] ) {?>
                        <div class="teslimat-onaybutton-main">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="sozlesme_onayi" value="1" class="custom-control-input" id="sozlesmeOnay"  checked>
                                <label class="custom-control-label" for="sozlesmeOnay" style="font-size: 14px ; ">
                                    <a  data-toggle="modal" data-target="#sozlesmeModal" style="color: #333; cursor: pointer ">
                                        <strong style="text-decoration: underline;"><?=$diller['teslimat-sayfa-form-onay-text1']?></strong></a>
                                    <?=$diller['teslimat-sayfa-form-onay-text2']?>
                                </label>
                            </div>
                        </div>
                        <!-- Sözleşme MODAL -->
                        <div class="modal " id="sozlesmeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
                                <div class="modal-content shadow-lg">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="exampleModalCenterTitle" style="font-weight: bold;">
                                            <?=$sozlesme['baslik']?>
                                        </h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="font-size: 14px ;" >
                                        <?=$sozlesme['icerik']?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="button-black button-1x" data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sözleşme MODAL -->

                        <?php if($uyeAdres->rowCount() > '0'  ) {?>
                            <button type="submit" id="shopButton" name="paymentValueGo" class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; font-size: 18px ;  ">
                                <?=$diller['teslimat-sayfa-form-button']?>
                            </button>
                        <?php }else { ?>
                            <a  href="" data-toggle="modal" data-target="#adresnomodal"  class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; font-size: 18px ; text-align: center;  ">
                                <?=$diller['teslimat-sayfa-form-button']?>
                            </a>

                            <!-- adres yok modalı !-->
                            <div class="modal " id="adresnomodal" data-backdrop="static" >
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content shadow-lg">
                                        <div style="position: absolute; z-index: 9; right: 10px">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none; color: #FFF;">
                                                <i class="ion-ios-close-empty"></i>
                                            </button>
                                        </div><div class="teslimat-bilgi-hata-main-text-h">
                                            <i class="fa fa-exclamation-triangle"></i> <?=$diller['teslimat-form-hata-baslik']?>
                                        </div>
                                        <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">

                                            <?=$diller['teslimat-uye-text-1']?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  <========SON=========>>> adres yok modalı SON !-->

                        <?php }?>
                    <?php } ?>
                <?php }?>
            <?php }?>

        </div>
        <!-- Ödeme türü ve sepet özeti alanı SON !-->
    </div>
</div>
</form>
<?php if($_SESSION['adres_alert'] =='success'  ) {?>
    <div class="modal fade" id="okArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                    <div>
                        <?=$diller['users-panel-text92']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#okArea').modal('show');
        });
        $(window).load(function () {
            $('#okArea').modal('show');
        });
        var $modalDialog = $("#okArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['adres_alert']); ?>
<?php }?>
<?php if($_SESSION['adres_alert'] =='success_edit'  ) {?>
    <div class="modal fade" id="okArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: #66B483;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #66B483;"><?=$diller['alert-success']?></div>
                    <div>
                        <?=$diller['users-panel-text98']?>
                    </div>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x"  style="width: 100%; text-align: center; " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#okArea').modal('show');
        });
        $(window).load(function () {
            $('#okArea').modal('show');
        });
        var $modalDialog = $("#okArea");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['adres_alert']); ?>
<?php }?>
<!-- SÖZLEŞME ONAY SORUNU   !-->
<?php if($_SESSION['teslimat_alert'] == 'sozlesmeHata'  ) {?>
    <div class="modal fade" id="sozlesmeHata" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div style="position: absolute; z-index: 9; right: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none; color: #FFF;">
                        <i class="ion-ios-close-empty"></i>
                    </button>
                </div><div class="teslimat-bilgi-hata-main-text-h">
                    <i class="fa fa-exclamation-triangle"></i> <?=$diller['teslimat-form-hata-baslik']?>
                </div>
                <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">

                    <?=$diller['teslimat-form-hata-6']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#sozlesmeHata').modal('show');
        });
        $(window).load(function () {
            $('#sozlesmeHata').modal('show');
        });
        var $modalDialog = $("#sozlesmeHata");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teslimat_alert'] ) ?>
<?php }?>
<!-- SÖZLEŞME ONAY SORUNU SON !-->


<!-- ADRES SORUNU   !-->
<?php if($_SESSION['teslimat_alert'] == 'adresorunu'  ) {?>
    <div class="modal " id="adresorunu" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div style="position: absolute; z-index: 9; right: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none; color: #FFF;">
                        <i class="ion-ios-close-empty"></i>
                    </button>
                </div><div class="teslimat-bilgi-hata-main-text-h">
                    <i class="fa fa-exclamation-triangle"></i> <?=$diller['teslimat-form-hata-baslik']?>
                </div>
                <div class="modal-body" style="font-size: 14px ; font-weight: 300;  padding:  20px !important; letter-spacing: 0.04em!important;">

                    <?=$diller['teslimat-form-hata-5']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#adresorunu').modal('show');
        });
        $(window).load(function () {
            $('#adresorunu').modal('show');
        });
        var $modalDialog = $("#adresorunu");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teslimat_alert'] ) ?>
<?php }?>
<!-- ADRES SORUNU SON !-->


<!-- ShopButton Overlay !-->
<style>
    .shopButtonT{
        font-family : '<?=$odemeayar['sepet_font']?>',Sans-serif ;
    }
</style>

<div id="shopButtonOverlay">
    <div class="shopButtonT">
        <div><img src="images/load.svg" alt=""></div>
        <div><?=$diller['teslimat-uye-text-4']?></div>
    </div>
</div>
<!--  <========SON=========>>> ShopButton Overlay SON !-->



