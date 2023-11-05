<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$sozlesmeCek = $db->prepare("select * from htmlsayfa_sozlesmeler where tur=:tur and dil=:dil  ");
$sozlesmeCek->execute(array(
    'tur' => '1',
    'dil' => $_SESSION['dil']
));
$sozlesme = $sozlesmeCek->fetch(PDO::FETCH_ASSOC);

$ulkeCek = $db->prepare("select * from ulkeler where durum=:durum and dil=:dil order by sira asc ");
$ulkeCek->execute(array(
    'durum' => '1',
    'dil' => $_SESSION['dil']
));
$Fatura_ulkeCek = $db->prepare("select * from ulkeler where durum=:durum and dil=:dil order by sira asc ");
$Fatura_ulkeCek->execute(array(
    'durum' => '1',
    'dil' => $_SESSION['dil']
));
$TekulkeCek = $db->prepare("select * from ulkeler where durum=:durum and dil=:dil order by id desc limit 1 ");
$TekulkeCek->execute(array(
    'durum' => '1',
    'dil' => $_SESSION['dil']
));
$tekulke = $TekulkeCek->fetch(PDO::FETCH_ASSOC);
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


        
        <!-- Teslimat için kişisel veya kurumsal bilgiler !-->
        <div class="teslimat-bilgileri-div">


           <div class="teslimat-bilgileri-sol-kutular">
               <div class="teslimat-bilgi-baslik">
                   <?=$diller['teslimat-sayfa-baslik']?>
               </div>
               <div class="teslimat-form-area">
                   <div class="row">
                       <div class="form-group col-md-6">
                           <label for="isim">* <?=$diller['teslimat-sayfa-form-isim']?></label>
                           <input type="text" name="isim"  id="isim" value="<?=$_SESSION['form_temp']['isim']?>"  class="form-control" autocomplete="off">
                       </div>
                       <div class="form-group col-md-6">
                           <label for="soyisim">* <?=$diller['teslimat-sayfa-form-soyisim']?></label>
                           <input type="text" name="soyisim"  id="soyisim" value="<?=$_SESSION['form_temp']['soyisim']?>"   class="form-control" autocomplete="off">
                       </div>
                       <div class="form-group col-md-6">
                           <label for="eposta">* <?=$diller['teslimat-sayfa-form-eposta']?></label>
                           <div style="width: 100%; position: relative  ">
                               <input type="text" name="eposta"  id="eposta"  value="<?=$_SESSION['form_temp']['eposta']?>" class="form-control" autocomplete="off">
                               <div class="teslimat-icon"><i class="fa fa-envelope-o"></i></div>
                           </div>
                       </div>
                       <div class="form-group col-md-6">
                           <label for="tel">* <?=$diller['teslimat-sayfa-form-telefon']?></label>
                           <div style="width: 100%; position: relative; display: flex;  ">
                               <div style="width: 100%;  ">
                                   <input type="text" name="tel"   id="tel"  value="<?=$_SESSION['form_temp']['telefon']?>" class="form-control" autocomplete="off" placeholder="(___) ___-____" >
                                   <div class="teslimat-icon"><i class="fa fa-phone"></i></div>
                               </div>
                           </div>
                       </div>


                       <?php if( $odemeayar['faturasiz_teslimat'] == '0' ) {?>
                           <div class="form-group col-md-12">
                               <label for="tcno"><?=$diller['teslimat-sayfa-form-tc']?> <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?=$diller['teslimat-sayfa-form-tc-uyarisi']?>"></i></label>
                               <input type="number" name="tcno"  value="<?=$_SESSION['form_temp']['tc']?>" id="tcno"  class="form-control" autocomplete="off">
                           </div>
                       <?php }?>
                       <?php if( $odemeayar['faturasiz_teslimat'] == '1' ) {?>
                           <div class="form-group col-md-12">
                               <label for="tcno"><?php if($odemeayar['faturasiz_tc_zorunlu'] == '1' ) { ?>*<?php }else{?>(<?=$diller['teslimat-sayfa-form-tc-opsiyonel']?>)<?php }?> <?=$diller['teslimat-sayfa-form-tc']?></label>
                               <input type="number" name="tcno"   id="tcno" <?php if($odemeayar['faturasiz_tc_zorunlu'] == '1' ) { ?><?php }?> class="form-control" autocomplete="off">
                           </div>
                       <?php }?>



                       <?php if($ulkeCek->rowCount()>'0'  ) {?>

                           <?php if($ulkeCek->rowCount() == '1'  ) {?>


                           <?php if($odemeayar['teslimat_sehir'] == '0' ) { ?>

                           <?php if($tekulke['3_iso'] == 'TUR' ) {?>
                           <!-- Türkiye Seçili !-->
                           <div class="form-group col-md-6">
                               <label for="ulke">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                               <select name="ulke" class="form-control" id="ulke"  >
                                   <?php foreach ($ulkeCek as $ulke) {?>
                                       <option value="<?=$ulke['3_iso']?>"><?=$ulke['baslik']?></option>
                                   <?php }?>
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="il">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                               <select name="il" id="il" class="form-control" >
                                   <option value=""><?=$diller['teslimat-sayfa-form-secim-yap']?></option>
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="ilce">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                               <select name="ilce" id="ilce" class="form-control"  disabled="disabled" >
                                   <option value=""><?=$diller['teslimat-sayfa-form-secim-yap']?></option>
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                               <input type="text"  name="postakodu" placeholder="______"  id="postakodu"  maxlength="5"  value="<?=$_SESSION['form_temp']['postakodu']?>" class="form-control" autocomplete="off" >
                           </div>
                           <div class="form-group col-md-12">
                               <label for="adresbilgisi">* <?=$diller['teslimat-sayfa-form-adres']?></label>
                               <textarea name="adresbilgisi" id="adresbilgisi" class="form-control" rows="2" ><?=$_SESSION['form_temp']['adres']?></textarea>
                           </div>
                           <!-- Şehir-İlçe !-->
                           <script>
                               $.getJSON("assets/json/il-bolge.json", function(sonuc){
                                   $.each(sonuc, function(index, value){
                                       var row="";
                                       row +='<option value="'+value.il+'">'+value.il+'</option>';
                                       $("#il").append(row);
                                   })
                               });


                               $("#il").on("change", function(){
                                   var il=$(this).val();

                                   $("#ilce").attr("disabled", false).html("<option value=''><?=$diller['teslimat-sayfa-form-secim-yap']?></option>");
                                   $.getJSON("assets/json/il-ilce2.json", function(sonuc){
                                       $.each(sonuc, function(index, value){
                                           var row="";
                                           if(value.il==il)
                                           {
                                               row +='<option value="'+value.ilce+'">'+value.ilce+'</option>';
                                               $("#ilce").append(row);
                                           }
                                       });
                                   });
                               });
                           </script>
                           <!-- Şehir-İlçe SON !-->
                           <!-- Türkiye Seçili SON !-->

                       <?php }else { ?>
                           <!-- Türkiye harici ülke !-->

                           <div class="form-group col-md-6">
                               <label for="ulke">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                               <select name="ulke" class="form-control" id="ulke"  >
                                   <?php foreach ($ulkeCek as $ulke) {?>
                                       <option value="<?=$ulke['3_iso']?>"><?=$ulke['baslik']?></option>
                                   <?php }?>
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="il">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                               <input type="text" name="il"  id="il"  class="form-control">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="ilce">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                               <input type="text" name="ilce"  id="ilce"  class="form-control">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                               <input type="text"  name="postakodu" placeholder="______"  id="postakodu"  maxlength="5"  value="<?=$_SESSION['form_temp']['postakodu']?>" class="form-control" autocomplete="off" >
                           </div>
                           <div class="form-group col-md-12">
                               <label for="adresbilgisi">* <?=$diller['teslimat-sayfa-form-adres']?></label>
                               <textarea name="adresbilgisi" id="adresbilgisi" class="form-control" rows="2" ><?=$_SESSION['form_temp']['adres']?></textarea>
                           </div>

                           <!-- Türkiye harici ülke SON !-->
                       <?php }?>

                       <?php }else { ?>
                           <!-- Tek Şehir Seçili !-->

                           <div class="form-group col-md-6">
                               <label for="ulke">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                               <select name="ulke" class="form-control" id="ulke"  >
                                   <?php foreach ($ulkeCek as $ulke) {?>
                                       <option value="<?=$ulke['3_iso']?>"><?=$ulke['baslik']?></option>
                                   <?php }?>
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="il">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                               <select name="il" class="form-control" id="il"  >
                                   <option value="<?=$odemeayar['teslimat_sehir']?>"><?=$odemeayar['teslimat_sehir']?></option>
                               </select>
                           </div>
                           <div class="form-group col-md-6">
                               <label for="ilce">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                               <input type="text" name="ilce"  id="ilce"  class="form-control">
                           </div>
                           <div class="form-group col-md-6">
                               <label for="postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                               <input type="text"  name="postakodu" placeholder="______"  id="postakodu"  maxlength="5"  value="<?=$_SESSION['form_temp']['postakodu']?>" class="form-control" autocomplete="off" >
                           </div>
                           <div class="form-group col-md-12">
                               <label for="adresbilgisi">* <?=$diller['teslimat-sayfa-form-adres']?></label>
                               <textarea name="adresbilgisi" id="adresbilgisi" class="form-control" rows="2" ><?=$_SESSION['form_temp']['adres']?></textarea>
                           </div>

                           <!-- Tek Şehir Seçili SON !-->

                       <?php }?>

                       <?php }else { ?>
                           <!-- 1'den fazla o nedenle tek şehir sistemi iptal !-->
                           <div class="form-group col-md-12">
                               <label for="ulke">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                               <select name="ulke" class="form-control" id="ulke"  >
                                   <option value=""><?=$diller['teslimat-sayfa-form-ulke-sec']?></option>
                                   <?php foreach ($ulkeCek as $ulke) {?>
                                       <option value="<?=$ulke['3_iso']?>"><?=$ulke['baslik']?></option>
                                   <?php }?>
                               </select>
                           </div>
                           <div id="show" style="width: 100%;  "  >
                           </div>
                           <!-- 1'den fazla o nedenle tek şehir sistemi iptal SON !-->
                       <?php }?>

                       <?php }else { ?>
                           <div class="form-group col-md-12">
                               <label for="hataCountry">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                               <br>
                               <small style="font-size: 11px ; line-height: 12px; color: red;"><i class="fa fa-info-circle"></i> <?=$diller['teslimat-sayfa-form-ulke-yok-aciklama']?></small>
                               <select name="hataCountry" class="form-control" id="hataCountry"  >
                                   <option value=""><?=$diller['teslimat-sayfa-form-ulke-yok']?></option>
                               </select>
                           </div>
                       <?php }?>

                   </div>
               </div>
           </div>
            
            
            
            <?php if($odemeayar['faturasiz_teslimat'] == '0' ) {?>
            <div class="teslimat-bilgileri-sol-kutular-dar">
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="fatura_farkli" value="0" >
                    <input type="checkbox" name="fatura_farkli" value="1" onclick="checkMe(this.checked);" class="custom-control-input" id="fatura_farkli">
                    <label class="custom-control-label" for="fatura_farkli"><?=$diller['teslimat-sayfa-form-fatura-uyari']?></label>
                </div>
            </div>



           <div id="faturagir"class="teslimat-bilgileri-sol-kutular" style="display: none">
                <div class="teslimat-bilgi-baslik">
                    <?=$diller['teslimat-sayfa-form-fatura-baslik']?>
                </div>

                <div class="teslimat-form-area" >

                    <div class="teslimat-uyelik-tipi fatura-secim">
                        <div class="rdio rdio-primary font-14 ">
                            <input name="fatura_turu" value="fatura_turu1" id="fatura_turu1" type="radio" <?php if(!isset($_SESSION['form_temp']['fatura_tip'])) { ?>checked<?php }else{?><?php if($_SESSION['form_temp']['fatura_tip'] == 'fatura_turu1' ) { ?>checked<?php }?><?php } ?>>
                            <label for="fatura_turu1"><?=$diller['teslimat-sayfa-form-fatura-bireysel']?></label>
                        </div>
                        <div class="rdio rdio-primary font-14">
                            <input name="fatura_turu" value="fatura_turu2" id="fatura_turu2" type="radio" <?php if($_SESSION['form_temp']['fatura_tip'] == 'fatura_turu2' ) { ?>checked<?php }?>>
                            <label for="fatura_turu2"><?=$diller['teslimat-sayfa-form-fatura-kurumsal']?></label>
                        </div>
                    </div>

                    <div class="fatura-secim-bireysel row" >
                        <!-- Bireysel !-->
                        <div class="form-group col-md-4">
                            <label for="fatura_isim">* <?=$diller['teslimat-sayfa-form-isim']?></label>
                            <input type="text" name="fatura_isim"  id="fatura_isim" value="<?=$_SESSION['form_temp']['fatura_isim']?>" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fatura_soyisim">* <?=$diller['teslimat-sayfa-form-soyisim']?></label>
                            <input type="text" name="fatura_soyisim"  id="fatura_soyisim"  class="form-control" value="<?=$_SESSION['form_temp']['fatura_soyisim']?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fatura_tc">* <?=$diller['teslimat-sayfa-form-tc']?></label>
                            <input type="number" name="fatura_tc" placeholder="************" id="fatura_tc"  class="form-control" value="<?=$_SESSION['form_temp']['fatura_tc']?>" autocomplete="off">
                        </div>
                         <!-- Bireysel SON !-->
                    </div>


                    <div class="fatura-secim-kurumsal row" >
                        <!-- Kurumsal !-->
                        <div class="form-group col-md-4">
                            <label for="fatura_firma_unvan">* <?=$diller['teslimat-sayfa-form-fatura-firma-unvan']?></label>
                            <input type="text" name="fatura_firma_unvan"  id="fatura_firma_unvan"  class="form-control" value="<?=$_SESSION['form_temp']['fatura_unvan']?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fatura_vergi_dairesi">* <?=$diller['teslimat-sayfa-form-fatura-firma-vergidaire']?></label>
                            <input type="text" name="fatura_vergi_dairesi"  id="fatura_vergi_dairesi"  class="form-control" value="<?=$_SESSION['form_temp']['fatura_vd']?>" autocomplete="off">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fatura_vergi_no">* <?=$diller['teslimat-sayfa-form-fatura-firma-vergino']?></label>
                            <input type="number" name="fatura_vergi_no"  id="fatura_vergi_no"  class="form-control" value="<?=$_SESSION['form_temp']['fatura_vn']?>" autocomplete="off">
                        </div>
                        <!-- Kurumsal SON !-->
                    </div>


                    <?php if($Fatura_ulkeCek->rowCount()>'0'  ) {?>
                        <?php if($Fatura_ulkeCek->rowCount() == '1'  ) {?>
                            <!-- Tek ülke var !-->
                            <?php if($tekulke['3_iso'] == 'TUR' ) {?>
                                <!-- Türkiye !-->
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="fatura_ulke">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                                        <select name="fatura_ulke" class="form-control" id="fatura_ulke" >
                                            <option value="<?=$ulke['3_iso']?>"><?=$ulke['baslik']?></option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="il2">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                                        <select name="fatura_il" id="il2" class="form-control">
                                            <option value=""><?=$diller['teslimat-sayfa-form-secim-yap']?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ilce2">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                                        <select name="fatura_ilce" id="ilce2" class="form-control" disabled="disabled">
                                            <option value=""><?=$diller['teslimat-sayfa-form-secim-yap']?></option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="fatura_postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                                        <input type="text" name="fatura_postakodu" placeholder="______"  id="fatura_postakodu" maxlength="5" value="<?=$_SESSION['form_temp']['fatura_posta']?>"  class="form-control" autocomplete="off" >
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="fatura_adresbilgisi">* <?=$diller['teslimat-sayfa-form-fatura-adres']?></label>
                                        <textarea name="fatura_adresbilgisi" id="fatura_adresbilgisi" class="form-control" rows="2" ><?=$_SESSION['form_temp']['fatura_adresi']?></textarea>
                                    </div>
                                </div>
                                <script>
                            $.getJSON("assets/json/il-bolge.json", function(sonuc){
                                $.each(sonuc, function(index, value){
                                    var row="";
                                    row +='<option value="'+value.il+'">'+value.il+'</option>';
                                    $("#il2").append(row);
                                })
                            });


                            $("#il2").on("change", function(){
                                var il=$(this).val();

                                $("#ilce2").attr("disabled", false).html("<option value=''><?=$diller['teslimat-sayfa-form-secim-yap']?></option>");
                                $.getJSON("assets/json/il-ilce2.json", function(sonuc){
                                    $.each(sonuc, function(index, value){
                                        var row="";
                                        if(value.il==il)
                                        {
                                            row +='<option value="'+value.ilce+'">'+value.ilce+'</option>';
                                            $("#ilce2").append(row);
                                        }
                                    });
                                });
                            });
                        </script>
                                <!-- Türkiye SON !-->

                            <?php }else { ?>
                                <!-- Diğer Ülkeler !-->
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="fatura_ulke">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                                        <select name="fatura_ulke" class="form-control" id="fatura_ulke" >
                                            <?php foreach ($Fatura_ulkeCek as $faturaulke) {?>
                                            <option value="<?=$faturaulke['3_iso']?>"><?=$faturaulke['baslik']?></option>
                                            <?php }?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="il2">* <?=$diller['teslimat-sayfa-form-sehir']?></label>
                                        <input type="text" name="fatura_il" id="il2"  class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ilce2">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                                        <input type="text" name="fatura_ilce" id="ilce2"  class="form-control">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="fatura_postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                                        <input type="text" name="fatura_postakodu" placeholder="______"  id="fatura_postakodu" maxlength="5" value="<?=$_SESSION['form_temp']['fatura_posta']?>"  class="form-control" autocomplete="off" >
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="fatura_adresbilgisi">* <?=$diller['teslimat-sayfa-form-fatura-adres']?></label>
                                        <textarea name="fatura_adresbilgisi" id="fatura_adresbilgisi" class="form-control" rows="2" ><?=$_SESSION['form_temp']['fatura_adresi']?></textarea>
                                    </div>
                                </div>
                                <!-- Diğer Ülkeler SON !-->
                            <?php }?>
                            <!-- Tek ülke var SON !-->
                        <?php }else { ?>
                            <!-- Çok Ülke Var !-->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="fatura_ulke">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                            <select name="fatura_ulke" class="form-control" id="fatura_ulke"  >
                                <option value=""><?=$diller['teslimat-sayfa-form-fatura-ulke-sec']?></option>
                                <?php foreach ($Fatura_ulkeCek as $faturaulke) {?>
                                    <option value="<?=$faturaulke['3_iso']?>"><?=$faturaulke['baslik']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div id="show_fatura" style="width: 100%;  "  ></div>
                            <!-- Çok Ülke Var SON !-->
                        <?php }?>
                    <?php }else { ?>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="hataCountry">* <?=$diller['teslimat-sayfa-form-ulke']?></label>
                            <br>
                            <small style="font-size: 11px ; line-height: 12px; color: red;"><i class="fa fa-info-circle"></i> <?=$diller['teslimat-sayfa-form-ulke-yok-aciklama']?></small>
                            <select name="hataCountry" class="form-control" id="hataCountry"  >
                                <option value=""><?=$diller['teslimat-sayfa-form-ulke-yok']?></option>
                            </select>
                        </div>
                    </div>
                    <?php }?>



                </div>
            </div>
            <?php }?>
            
            
            
            
            <div class="teslimat-bilgileri-sol-kutular">
                <div class="teslimat-bilgi-baslik">
                   <?=$diller['teslimat-sayfa-form-siparis-not']?>
                </div>
                <div class="teslimat-form-area">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <textarea name="siparis_notu" id="siparis_notu" class="form-control" rows="3" ><?=$_SESSION['form_temp']['siparis_notu']?></textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Teslimat için kişisel veya kurumsal bilgiler SON !-->

        
        <!-- Ödeme türü ve sepet özeti alanı !-->
        <div class="teslimat-sag-taraf">


            <?php if(($aratoplam+$kargotoplami+$kdvtoplami)-$sepette_ek_indirim <='0'   ) {?>
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
                                        </div> </label>
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
                                        </div></label>
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
                            <?php if($kdvtoplami>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-kdv']?></div>
                                    <div class="font-17 font-bold">
                                        <?=kur_cekimi($kdvtoplami)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($sepette_ek_indirim>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ek-indirim']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($sepette_ek_indirim)?>
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
                                    <?=kur_cekimi(($aratoplam+$kargotoplami+$kdvtoplami)-$sepette_ek_indirim)?>
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
                            <?php if($kdvtoplami>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ozet-kdv']?></div>
                                    <div class="font-17 font-bold">
                                        <?=kur_cekimi($havale_kdvtoplam)?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if($sepette_ek_indirim_havale>'0'  ) {?>
                                <div class="teslimat-sepet-ozet-main-box">
                                    <div class="font-15"><?=$diller['sepet-ek-indirim']?></div>
                                    <div class="font-17 font-bold">
                                        - <?=kur_cekimi($sepette_ek_indirim)?>
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
                                    <?=kur_cekimi($havale_odenecek_tutar-$sepette_ek_indirim_havale)?>
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
                                <?php if($kdvtoplami>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ozet-kdv']?></div>
                                        <div class="font-17 font-bold">
                                            <?=kur_cekimi($kdvtoplami)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($sepette_ek_indirim>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ek-indirim']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($sepette_ek_indirim)?>
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
                                        <?=kur_cekimi(($aratoplam+$kargotoplami+$kdvtoplami+$kapida_kart)-$sepette_ek_indirim)?>
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
                                <?php if($kdvtoplami>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ozet-kdv']?></div>
                                        <div class="font-17 font-bold">
                                            <?=kur_cekimi($kdvtoplami)?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if($sepette_ek_indirim>'0'  ) {?>
                                    <div class="teslimat-sepet-ozet-main-box">
                                        <div class="font-15"><?=$diller['sepet-ek-indirim']?></div>
                                        <div class="font-17 font-bold">
                                            - <?=kur_cekimi($sepette_ek_indirim)?>
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
                                        <?=kur_cekimi(($aratoplam+$kargotoplami+$kdvtoplami+$kapida_nakit)-$sepette_ek_indirim)?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                <?php }?>



            <?php }?>



            <?php if($odemeayar['kredi_kart'] == '1' || $odemeayar['havale_eft'] == '1') {?>
            <?php if($sozlesmeCek->rowCount()>'0'  ) {?>
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
                        <div class="modal-content">
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
                <?php } ?>
                <button type="submit" id="shopButton" name="paymentValueGo" class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; font-size: 18px ;  ">
                    <?=$diller['teslimat-sayfa-form-button']?>
                </button>
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
                                <div class="modal-content">
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

                        <button type="submit" id="shopButton" name="paymentValueGo" class="<?=$odemeayar['sepet_page_button_bg']?> button-2x" style="width: 100%; font-size: 18px ;  ">
                            <?=$diller['teslimat-sayfa-form-button']?>
                        </button>
                    <?php } ?>
                    <?php }?>
            <?php }?>









        </div>




        <!-- Ödeme türü ve sepet özeti alanı SON !-->

    </div>
</div>
</form>


<!-- Boş alan var !-->
<?php if($_SESSION['teslimat_alert'] == 'empty'  ) {?>
    <?php unset($_SESSION['teslimat_alert'] ) ?>
    <div class="modal " id="emptyDurum" data-backdrop="static" >
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div style="position: absolute; z-index: 9; right: 10px">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="outline: none; color: #FFF;">
                        <i class="ion-ios-close-empty"></i>
                    </button>
                </div><div class="teslimat-bilgi-hata-main-text-h">
                    <i class="fa fa-exclamation-triangle"></i> <?=$diller['teslimat-form-hata-baslik']?>
                </div>
                <div class="modal-body" style="font-size: 14px ; font-weight: 300; padding:  20px !important; letter-spacing: 0.04em!important;">

                    <?=$diller['teslimat-form-hata-1']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#emptyDurum').modal('show');
        });
        $(window).load(function () {
            $('#emptyDurum').modal('show');
        });
        var $modalDialog = $("#emptyDurum");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
<?php }?>
<!-- Boş alan var SON !-->

<!-- TC EKLENMEMİŞ  !-->
<?php if($_SESSION['teslimat_alert'] == 'tczorunlu'  ) {?>

    <div class="modal " id="tczorunlu" data-backdrop="static" >
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

                    <?=$diller['teslimat-form-hata-2']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#tczorunlu').modal('show');
        });
        $(window).load(function () {
            $('#tczorunlu').modal('show');
        });
        var $modalDialog = $("#tczorunlu");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teslimat_alert'] ) ?>
<?php }?>
<?php if($_SESSION['teslimat_alert'] == 'faturasiztczorunlu'  ) {?>

    <div class="modal " id="tczorunlu" data-backdrop="static" >
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

                    <?=$diller['teslimat-form-hata-7']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#tczorunlu').modal('show');
        });
        $(window).load(function () {
            $('#tczorunlu').modal('show');
        });
        var $modalDialog = $("#tczorunlu");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teslimat_alert'] ) ?>
<?php }?>
<!-- TC EKLENMEMİŞ SON !-->

<!-- FATURA BİLGİSİNDE BOŞ VAR   !-->
<?php if($_SESSION['teslimat_alert'] == 'faturazorunlu'  ) {?>
    <div class="modal " id="faturazorunlu" data-backdrop="static" >
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

                    <?=$diller['teslimat-form-hata-3']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-black button-2x"  data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#faturazorunlu').modal('show');
        });
        $(window).load(function () {
            $('#faturazorunlu').modal('show');
        });
        var $modalDialog = $("#faturazorunlu");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teslimat_alert'] ) ?>
<?php }?>
<!-- FATURA BİLGİSİNDE BOŞ VAR SON  !-->

<!-- HATALI EPOSTA   !-->
<?php if($_SESSION['teslimat_alert'] == 'emailhata'  ) {?>
    <div class="modal " id="emailhata" data-backdrop="static" >
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

                    <?=$diller['teslimat-form-hata-4']?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="button-black button-2x"   data-dismiss="modal"><?=$diller['alert-button-ok']?></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(window).on("load", function() {
            $('#emailhata').modal('show');
        });
        $(window).load(function () {
            $('#emailhata').modal('show');
        });
        var $modalDialog = $("#emailhata");
        $modalDialog.modal('show');

        setTimeout(function() {
            $modalDialog.modal('hide');
        }, 0);
    </script>
    <?php unset($_SESSION['teslimat_alert'] ) ?>
<?php }?>
<!-- HATALI EPOSTA SON !-->
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