<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>

<?php if($odemeayar['sepet_kupon'] =='1' && $aktifSepet->rowCount()>'0' && $uyeayar['durum'] == '1' ) {?>
<?php if($userSorgusu->rowCount()>'0'  ) {?>
        <div class="cart-right-div-inside" style="margin-bottom: 10px !important;" >
            <div class="cart-right-div-head">
                <?=$diller['sepet-indirim-kupon-baslik']?>
            </div>
            <div class="cart-right-div-s">
                <?=$diller['sepet-indirim-kupon-aciklama']?>
            </div>
            <div class="cart-right-div-coupon">
                <form action="discount" method="post" style="  ">
                    <input type="text" name="discount" autocomplete="off"  placeholder="<?=$diller['sepet-indirim-kupon-girin']?>"  >
                    <button id="shopButton" name="discountValue" class="<?=$odemeayar['sepet_kupon_button']?> " ><?=$diller['sepet-indirim-kupon-button']?></button>
                </form>
            </div>
        </div>
    <?php }else { ?>
        <div class="cart-right-div-inside" style="margin-bottom: 10px " >
            <div class="cart-right-div-head">
                <?=$diller['sepet-indirim-kupon-baslik']?>
            </div>
            <div class="cart-right-div-s">
                <?=$diller['sepet-indirim-kupon-aciklama']?>
            </div>
            <div class="cart-right-div-coupon">
                    <input type="text"  name="" id=""  autocomplete="off"  style="flex:1">
                    <button data-toggle="modal" data-target="#discountModal"  class="<?=$odemeayar['sepet_kupon_button']?> " ><?=$diller['sepet-indirim-kupon-button']?></button>
                    <div class="modal fade" id="discountModal"  >
                        <div class="modal-dialog modal-dialog-centered modal-sm ">
                            <div class="modal-content">
                                <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:0 !important; border:0 !important;">&times;</a>
                                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                                    <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                                    <div>
                                        <?=$diller['sepet-indirim-kupon-modal-aciklama']?>
                                    </div>
                                </div>
                                <div class="category-cart-add-success-modal-footer">
                                    <a href="uye-girisi/" class="button-blue button-2x"  style="width: 100%; text-align: center; " ><?=$diller['sepet-indirim-kupon-modal-button']?></a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    <?php }?>
<?php } ?>

<?php if($OnaySepetSorgusu->rowCount()>'0'  ) {?>
   <?php if($uyeayar['durum'] == '1' ) {?>
        <!-- Üyelik aktif  !-->
        <?php if($userSorgusu->rowCount()>'0'  ) {?>
                <!-- Üye Girişi Yapılmış !-->
            <div class="cart-right-div-inside">
                <div class="cart-right-div-head">
                    <?=$diller['sepet-ozet-yazisi']?>
                </div>


                <div class="cart-right-div-price-box">
                    <div class="cart-right-div-price-box-left">
                        <?=$diller['sepet-ozet-ara-toplam']?>
                    </div><div class="cart-right-div-price-box-right">
                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                            <?=$secilikur['sol_simge']?>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                            <?=$secilikur['sag_simge']?>
                        <?php }?>
                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$aratoplam), $secilikur['para_format']); ?>
                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                            <?=$secilikur['sol_simge']?>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                            <?=$secilikur['sag_simge']?>
                        <?php }?>
                    </div>
                </div>

                <?php if($indirimtutar > '0'  ) {
                    $sepetKuponSayi = $db->prepare("select * from sepet_kupon where uye_id=:uye_id and durum=:durum and kullanim=:kullanim  ");
                    $sepetKuponSayi->execute(array(
                        'uye_id' => $userCek['id'],
                        'durum' => '1',
                        'kullanim' => '0'
                    ));

                    $sepetKuponSorgula = $db->prepare("select * from sepet_kupon where uye_id=:uye_id and durum=:durum and kullanim=:kullanim order by id desc limit 1 ");
                    $sepetKuponSorgula->execute(array(
                        'uye_id' => $userCek['id'],
                        'durum' => '1',
                        'kullanim' => '0'
                    ));
                    $kuponRow = $sepetKuponSorgula->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="cart-right-div-price-box" >
                        <div class="cart-right-div-price-box-left">
                            <a href="removecoupon?cID=<?=$kuponRow['random_id']?>" style="text-decoration: none; color: indianred;">
                                <i class="fa fa-window-close"  data-toggle="tooltip" data-placement="left" title="<?=$diller['sepet-indirim-kupon-sil']?>"></i>
                            </a>
                            <?=$diller['sepet-ozet-kupon-indirim-tutar']?> <?php if($sepetKuponSayi->rowCount()>'1'  ) { ?><span style="font-size: 11px ; font-weight: 700;">(<?=$sepetKuponSayi->rowCount()?>)</span><?php }?>
                        </div><div class="cart-right-div-price-box-right">
                            -
                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$indirimtutar), $secilikur['para_format']); ?>
                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>

                <?php if($grubindirimi>'0'  ) {?>
                    <div class="cart-right-div-price-box">
                        <div class="cart-right-div-price-box-left">
                            <?=$diller['sepet-size-ozel-indirim']?>
                        </div><div class="cart-right-div-price-box-right">
                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                            - <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$grubindirimi), $secilikur['para_format']); ?>
                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>



                <?php if($sepette_ek_indirim>'0'  ) {?>
                    <div class="cart-right-div-price-box">
                        <div class="cart-right-div-price-box-left">
                            <?=$diller['sepet-ek-indirim']?>
                        </div><div class="cart-right-div-price-box-right">
                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                            - <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$sepette_ek_indirim), $secilikur['para_format']); ?>
                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>

                <?php if($ilk_sip_indirim>'0'  ) {?>
                    <div class="cart-right-div-price-box">
                        <div class="cart-right-div-price-box-left">
                            <?=$diller['sepet-ilk-siparis-indirim']?>
                        </div><div class="cart-right-div-price-box-right">
                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                            - <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$ilk_sip_indirim), $secilikur['para_format']); ?>
                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>


                <?php if($kdvtoplami>'0'  ) {?>
                    <div class="cart-right-div-price-box">
                        <div class="cart-right-div-price-box-left">
                            <?=$diller['sepet-ozet-kdv']?>
                        </div><div class="cart-right-div-price-box-right">
                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                            <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$kdvtoplami), $secilikur['para_format']); ?>
                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>





                <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                    <div class="cart-right-div-price-box">
                        <div class="cart-right-div-price-box-left">
                            <?=$diller['sepet-ozet-kargo-tutar']?>
                        </div><div class="cart-right-div-price-box-right">
                            <?php if($kargotoplami > '0'  ) {?>
                                <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                    <?=$secilikur['sol_simge']?>
                                <?php }?>
                                <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                    <?=$secilikur['sag_simge']?>
                                <?php }?>
                                <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$kargotoplami), $secilikur['para_format']); ?>
                                <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                    <?=$secilikur['sol_simge']?>
                                <?php }?>
                                <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                    <?=$secilikur['sag_simge']?>
                                <?php }?>
                            <?php }else { ?>
                                <span style="font-size: 12px ;"><?=$diller['urunler-ucretsiz-kargo-yazisi']?></span>
                            <?php }?>

                        </div>
                    </div>
                <?php }?>



                <div class="cart-right-div-price-box">
                    <div class="cart-right-div-price-box-left">
                        <?=$diller['sepet-ozet-odenecek-tutar']?>
                    </div><div class="cart-right-div-price-box-right font-16">
                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                            <?=$secilikur['sol_simge']?>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                            <?=$secilikur['sag_simge']?>
                        <?php }?>
                       <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],(((($aratoplam+$kargotoplami+$kdvtoplami)-$indirimtutar)-$sepette_ek_indirim)-$ilk_sip_indirim)-$grubindirimi), $secilikur['para_format']); ?>
                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                            <?=$secilikur['sol_simge']?>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                            <?=$secilikur['sag_simge']?>
                        <?php }?>
                    </div>
                </div>



                <!-- ücretsiz kargo için sayaç !-->
                <?php if($kargotoplami>'0' && $odemeayar['kargo_limit_sepet_sayac'] == '1' && $odemeayar['kargo_limit'] > '0' ) {?>
                    <div class="<?=$odemeayar['kargo_limit_sepet_sayac_button']?> button-2x" style="width: 100%; text-align: center; margin-bottom: 10px; ">
                        <i class="fa fa-truck" style="font-size: 18px ;"></i><br>
                        <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                            <?=$secilikur['sol_simge']?>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                            <?=$secilikur['sag_simge']?>
                        <?php }?>
                        <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$odemeayar['kargo_limit']-(($aratoplam+$kdvtoplami)-$indirimtutar)), $secilikur['para_format']); ?>
                        <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                            <?=$secilikur['sol_simge']?>
                        <?php }?>
                        <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                            <?=$secilikur['sag_simge']?>
                        <?php }?>
                        <?=$diller['sepet-kargo-limit-kalan']?>
                    </div>
                <?php }?>
                <!-- ücretsiz kargo için sayaç SON !-->



                <a href="teslimat/"  class="<?=$odemeayar['sepet_page_button_bg']?> button-4x" style="width: 100%;  font-weight: 500;  text-align: center; "  >
                    <?=$diller['sepet-onayla-button']?>
                </a>


            </div>
                <!-- Üye Girişi Yapılmış SON !-->
        <?php }else { ?>
                <!-- Giriş Yapılmamış! üye girişi modal ve üyeliksiz devam et çıksın !-->
            <div class="cart-right-div-inside">
                <div class="cart-right-div-head">
                    <?=$diller['sepet-ozet-yazisi']?>
                </div>


                <div class="cart-right-div-price-box">
                    <div class="cart-right-div-price-box-left">
                        <?=$diller['sepet-ozet-ara-toplam']?>
                    </div><div class="cart-right-div-price-box-right">

                        <?=kur_cekimi($aratoplam)?>

                    </div>
                </div>

                <?php if($kdvtoplami>'0'  ) {?>
                    <div class="cart-right-div-price-box">
                        <div class="cart-right-div-price-box-left">
                            <?=$diller['sepet-ozet-kdv']?>
                        </div><div class="cart-right-div-price-box-right">

                            <?=kur_cekimi($kdvtoplami)?>

                        </div>
                    </div>
                <?php }?>


                <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                    <div class="cart-right-div-price-box">
                        <div class="cart-right-div-price-box-left">
                            <?=$diller['sepet-ozet-kargo-tutar']?>
                        </div><div class="cart-right-div-price-box-right">
                            <?php if($kargotoplami>'0'  ) {?>
                                <?=kur_cekimi($kargotoplami)?>
                            <?php }else { ?>
                                <span style="font-size: 12px ;"><?=$diller['urunler-ucretsiz-kargo-yazisi']?></span>
                            <?php }?>

                        </div>
                    </div>
                <?php }?>

                <?php if($sepette_ek_indirim>'0'  ) {?>
                    <div class="cart-right-div-price-box">
                        <div class="cart-right-div-price-box-left">
                            <?=$diller['sepet-ek-indirim']?>
                        </div><div class="cart-right-div-price-box-right">
                            <?php if($secilikur['simge_gosterim'] == '0' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '1' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                            - <?php echo number_format(kurhesapla($varsayilankur['deger'],$secilikur['deger'],$sepette_ek_indirim), $secilikur['para_format']); ?>
                            <?php if($secilikur['simge_gosterim'] == '2' ) {?>
                                <?=$secilikur['sol_simge']?>
                            <?php }?>
                            <?php if($secilikur['simge_gosterim'] == '3' ) {?>
                                <?=$secilikur['sag_simge']?>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>


                <div class="cart-right-div-price-box">
                    <div class="cart-right-div-price-box-left">
                        <?=$diller['sepet-ozet-odenecek-tutar']?>
                    </div><div class="cart-right-div-price-box-right font-16">
                        <?=kur_cekimi(($aratoplam+$kargotoplami+$kdvtoplami)-$sepette_ek_indirim)?>
                    </div>
                </div>



                <!-- ücretsiz kargo için sayaç !-->
                <?php if($kargotoplami>'0' && $odemeayar['kargo_limit_sepet_sayac'] == '1' && $odemeayar['kargo_limit'] > '0' ) {?>
                    <div class="<?=$odemeayar['kargo_limit_sepet_sayac_button']?> button-2x" style="width: 100%; text-align: center; margin-bottom: 10px; ">
                        <i class="fa fa-truck" style="font-size: 18px ;"></i><br>
                        <?=kur_cekimi($odemeayar['kargo_limit']-($aratoplam+$kdvtoplami))?>
                        <?=$diller['sepet-kargo-limit-kalan']?>
                    </div>
                <?php }?>
                <!-- ücretsiz kargo için sayaç SON !-->

                <a href="" data-toggle="modal" data-target="#loginModal"  style="color:#FFF; text-decoration: none; "  >
                    <div class="<?=$odemeayar['sepet_page_button_bg']?> button-4x" style="width: 100%; font-weight: 500; text-align: center;  ">
                        <?=$diller['sepet-onayla-button']?>
                    </div>
                </a>

                <!-- ÜYE GİRİŞ !-->
                <div class="modal fade " id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content shadow-lg rounded">
                            <div class="modal-in-login">
                                <a type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px; box-shadow:0 !important; border:0 !important;">
                                    &times;
                                </a>
                                <div class="modal-in-login-head">
                                    <div class="modal-in-login-head-h">
                                        <div class="modal-in-login-head-h-text">
                                            <?=$diller['uyegiris-modal-text1']?>
                                        </div>
                                    </div>
                                    <div class="modal-in-login-head-s">
                                        <?=$diller['uyegiris-modal-text12']?>
                                    </div>
                                </div>
                                <div class="modal-in-login-form teslimat-form-area">
                                    <form action="cartloginpage" method="post" >
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="emailadress" style="font-weight: 600;">* <?=$diller['uyegiris-modal-text3']?></label>
                                                <input type="email" name="emailadress" id="emailadress" required   class="form-control" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="password" style="font-weight: 600;">* <?=$diller['uyegiris-modal-text4']?></label>
                                                <input type="password" name="password" id="password" required   class="form-control" autocomplete="off">
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="rememberme" value="rememberme" class="custom-control-input" id="rememberme"  >
                                                    <label class="custom-control-label" for="rememberme" style="font-size: 14px !important ;  ">
                                                        <?=$diller['uyegiris-modal-text5']?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-8" style="text-align: right;">
                                                <a class="modal-in-login-form-reset-password" href="sifremi-unuttum/" target="_blank" ><?=$diller['uyegiris-modal-text6']?></a>
                                            </div>
                                            <div class="form-group col-md-12 " style="margin-top: 20px;">
                                                <button name="userlogin" class="button-blue button-2x"  style="width: 100%;  text-align: center; " ><?=$diller['uyegiris-modal-text7']?></button>
                                            </div>
                                            <?php if($uyeayar['yeni_uyelik'] == '1' ) {?>
                                                <div class="form-group col-md-12 " >
                                                    <a href="uyelik/" class="button-green button-2x" style="width: 100%;  text-align: center; ">
                                                        <i class="las la-user"></i>
                                                        <?=$diller['uyegiris-modal-text10']?>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <?php if($odemeayar['uyesiz_alisveris'] == '1' ) {?>
                                    <div class="modal-in-login-foot">
                                        <div class="modal-in-login-head-h">
                                            <div class="modal-in-login-head-h-text">
                                                <?=$diller['uyegiris-modal-text11']?>
                                            </div>
                                        </div>
                                        <a href="teslimat/" class="button-black-out  button-2x" style="width: 100%; text-align: center; "><?=$diller['uyegiris-modal-text13']?></a>
                                    </div>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ÜYE GİRİŞ SON !-->

            </div>
                <!-- Giriş Yapılmamış! üye girişi modal ve üyeliksiz devam et çıksın SON !-->
        <?php }?>
        <!-- Üyelik aktif  SON !-->
   <?php }else { ?>
    <!-- Sitede üyelik pasif- Üyeliksiz alışveriş yaptır !-->

        <div class="cart-right-div-inside">
            <div class="cart-right-div-head">
                <?=$diller['sepet-ozet-yazisi']?>
            </div>


            <div class="cart-right-div-price-box">
                <div class="cart-right-div-price-box-left">
                    <?=$diller['sepet-ozet-ara-toplam']?>
                </div><div class="cart-right-div-price-box-right">
                    <?=kur_cekimi($aratoplam)?>
                </div>
            </div>

            <?php if($kdvtoplami>'0'  ) {?>
                <div class="cart-right-div-price-box">
                    <div class="cart-right-div-price-box-left">
                        <?=$diller['sepet-ozet-kdv']?>
                    </div><div class="cart-right-div-price-box-right">
                        <?=kur_cekimi($kdvtoplami)?>
                    </div>
                </div>
            <?php }?>


            <?php if($odemeayar['kargo_sistemi'] == '1' ) {?>
                <div class="cart-right-div-price-box">
                    <div class="cart-right-div-price-box-left">
                        <?=$diller['sepet-ozet-kargo-tutar']?>
                    </div><div class="cart-right-div-price-box-right">
                        <?php if($kargotoplami>'0'  ) {?>
                            <?=kur_cekimi($kargotoplami)?>
                        <?php }else { ?>
                            <span style="font-size: 12px ;"><?=$diller['urunler-ucretsiz-kargo-yazisi']?></span>
                        <?php }?>

                    </div>
                </div>
            <?php }?>



            <div class="cart-right-div-price-box">
                <div class="cart-right-div-price-box-left">
                    <?=$diller['sepet-ozet-odenecek-tutar']?>
                </div><div class="cart-right-div-price-box-right font-16">
                    <?=kur_cekimi($aratoplam+$kargotoplami+$kdvtoplami)?>
                </div>
            </div>



            <!-- ücretsiz kargo için sayaç !-->
            <?php if($kargotoplami>'0' && $odemeayar['kargo_limit_sepet_sayac'] == '1' && $odemeayar['kargo_limit'] > '0' ) {?>
                <div class="<?=$odemeayar['kargo_limit_sepet_sayac_button']?> button-2x" style="width: 100%; text-align: center; margin-bottom: 10px;">
                    <i class="fa fa-truck" style="font-size: 18px ;"></i><br>
                    <?=kur_cekimi($odemeayar['kargo_limit']-($aratoplam+$kdvtoplami))?>
                    <?=$diller['sepet-kargo-limit-kalan']?>
                </div>
            <?php }?>
            <!-- ücretsiz kargo için sayaç SON !-->

                <a href="teslimat/"  class="<?=$odemeayar['sepet_page_button_bg']?> button-4x" style="width: 100%; font-weight: 500;  text-align: center; "  >
                    <?=$diller['sepet-onayla-button']?>
                </a>

        </div>
    <!-- Sitede üyelik pasif- Üyeliksiz alışveriş yaptır SON !-->
   <?php }?>


<?php }else { ?>
    <div class="cart-right-div-inside" style="font-size: 14px ; font-weight: bold;">
        <div class="alert alert-danger">
            <?=$diller['sepet-urunsuz-devam-edilemez']?>
        </div>
        <a href="<?=$ayar['site_url']?>" style="color:#FFF; text-decoration: none; "  >
            <div class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; text-align: center;  ">
                <?=$diller['sepet-alisverise-basla']?>
            </div>
        </a>
    </div>
<?php }?>

<?php if($_SESSION['login_success'] == 'success'  ) {?>
    <div class="modal fade" id="successLogin" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                    <i class="ion-ios-checkmark-outline" style="font-size: 60px ; color: green;"></i><br>
                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 24px ;"><?=$diller['uyegiris-modal-success-sepet-text1']?></div>
                    <?=$diller['uyegiris-modal-success-sepet-text2']?>
                </div>
                <div class="category-cart-add-success-modal-footer">
                    <button type="button" class="button-blue button-2x category-cart-add-success-modal-footer-button"  style=" " data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#successLogin').modal('show');
        });
        $(window).load(function () {
            $('#successLogin').modal('show');
        });
        var $modalDialog = $("#successLogin");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['login_success'] ) ?>
<?php }?>
<?php if($_SESSION['uyelik_durum'] =='success_onay'  ) {?>
    <div class="modal fade" id="okArea" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm ">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">

                    <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #4b7ece;"><?=$diller['alert-warning-2']?></div>
                    <div>
                        <?=$diller['users-text14-onaysiz']?>
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
    <?php unset($_SESSION['uyelik_durum']); ?>
<?php }?>


