<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
$adresID = trim(strip_tags($_GET['adresno']));
$adresCek = $db->prepare("select * from uyeler_adres where uye_id=:uye_id and adres_id=:adres_id ");
$adresCek->execute(array(
        'uye_id' => $userCek['id'],
        'adres_id' => $adresID,
));
$adresRow = $adresCek->fetch(PDO::FETCH_ASSOC);
if($userSorgusu->rowCount()>'0' && $adresCek->rowCount()>'0'  && $uyeayar['adres_alani'] == '1') {
$userpage = 'adres';
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
    
    if(isset($_SESSION['teslimat_adres_url'])  ) { 
     $returnValue = $_SESSION['teslimat_adres_url'];
    }else{
    $returnValue = 'account';
    }
?>
<title><?php echo $diller['users-adresler-duzenle-seo-title']; ?> - <?php echo $ayar['site_baslik']?></title>
    <meta name="robots" content="noindex">
    <meta name="googlebot" content="noindex">
    <META HTTP-EQUIV="Expire" CONTENT="now" />
    <META HTTP-EQUIV="pragma" CONTENT="no-cache" />
    <META HTTP-EQUIV="cache-control" CONTENT="no-cache" />

<?php include "includes/config/header_libs.php";?>
</head>
<body>
<?php include 'includes/template/pre-loader.php'?>
<?php include 'includes/template/header.php'?>

<style>
    .teslimat-form-area label{
        font-weight: 600;
    }
</style>
<!-- CONTENT AREA ============== !-->

<div class="users_main_div" style="background-color: #<?=$uyeayar['altsayfa_bg']?>;  font-family : '<?=$uyeayar['font_select']?>',sans-serif ; ">

    <div class="user_subpage_div">


        <!-- Header !-->
        <div class="user_page_header_subpage">
            <a href="<?=$ayar['site_url']?>"><?=$diller['users-panel-baglanti-text1']?></a>
           <i class="las la-angle-double-right"></i>
            <a ><?=$diller['users-panel-baglanti-text2']?></a>
           <i class="las la-angle-double-right"></i>
            <a href="hesabim/adresler/"><?=$diller['users-panel-baglanti-text10']?></a>
            <i class="las la-angle-double-right"></i>
            <a><?=$diller['users-panel-baglanti-text12']?></a>
        </div>
        <!--  <========SON=========>>> Header SON !-->
        <?php include 'includes/template/helper/users/leftbar.php'; ?>

        <!-- Right Content !-->
        <div class="user_subpage_coupon_content">

                <!-- Head !-->
                <div class="user_subpage_flex_header" style="flex-direction: column; ">
                    <div class="user_subpage_flex_header_back_href">
                        <?=$diller['users-panel-text87']?>
                        <a href="hesabim/adresler/">
                            <?=$diller['users-panel-text67']?>
                        </a>
                    </div>
                    <div class="user_subpage_flex_header_h">
                        <?=$diller['users-panel-text96']?>
                    </div>
                </div>
                <!--  <========SON=========>>> Head SON !-->

               <div class="user_subpage_info_div_blue">
                  <?=$diller['users-panel-text94']?>
                </div>


            <!-- Adres Form Area !-->
            <form action="user-address-editpost" method="post">
                <input type="hidden" name="returnValue" value="<?=$returnValue?>">
                <input type="hidden" name="addressHash" value="<?=md5($adresID)?>">
                <input type="hidden" name="addressNo" value="<?=$adresID?>">
                <div class="user_subpage_address_add_main_div">


                    <div class="user_subpage_address_add_border_div teslimat-form-area">
                        <div class="user_subpage_address_add_border_div_head">
                            <div class="user_subpage_address_add_border_div_head_in">
                               <i class="fa fa-map-marker"></i> <?=$diller['users-panel-text88']?>
                            </div>
                        </div>
                        <div class="row ">

                            <div class="form-group col-md-12" >
                                <div class="custom-control custom-checkbox" style=" border: 1px solid #49a781; border-radius: 3px; padding-top: 8px; padding-bottom: 8px;  background-color: #f6fffa; color: #000;" >
                                    <input type="hidden" name="secili" value="0" >
                                    <input type="checkbox" name="secili" value="1" class="custom-control-input" id="secili" <?php if($adresRow['secili'] == '1'  ) { ?>checked<?php }?> >
                                    <label class="custom-control-label" for="secili" style="font-size: 15px !important ; font-weight: normal; margin-left: 10px;">
                                        <?=$diller['users-panel-text93']?>
                                    </label>
                                </div>
                            </div>


                            <div class="form-group col-md-12">
                                <label for="baslik">* <?=$diller['users-panel-text90']?></label>
                                <input type="text" name="baslik"  id="baslik"  value="<?=$adresRow['baslik']?>" class="form-control" autocomplete="off" >
                            </div>

                            <div class="form-group col-md-12">
                                <label for="isim">* <?=$diller['teslimat-sayfa-form-isim']?></label>
                                <input type="text" name="isim"  id="isim"  value="<?=$adresRow['isim']?>" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="soyisim">* <?=$diller['teslimat-sayfa-form-soyisim']?></label>
                                <input type="text" name="soyisim"  id="soyisim" value="<?=$adresRow['soyisim']?>"  class="form-control" autocomplete="off">
                            </div>
                            <?php if($odemeayar['faturasiz_teslimat'] == '0' ) {?>
                                 <div class="form-group col-md-12">
                                <label for="eposta">* <?=$diller['teslimat-sayfa-form-eposta']?></label>
                                <div style="width: 100%; position: relative  ">
                                    <input type="text" name="eposta" value="<?=$adresRow['eposta']?>"  id="eposta"  class="form-control" autocomplete="off">
                                    <div class="teslimat-icon"><i class="fa fa-envelope-o"></i></div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="tel">* <?=$diller['teslimat-sayfa-form-telefon']?></label>
                                <div style="width: 100%; position: relative; display: flex;  ">
                                    <div style="width: 100%;  ">
                                        <input type="text" name="tel" value="<?=$adresRow['telefon']?>"  id="tel"  class="form-control" autocomplete="off" placeholder="(___) ___-____" >
                                        <div class="teslimat-icon"><i class="fa fa-phone"></i></div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                             <?php if($odemeayar['faturasiz_teslimat'] == '1' ) {?>
                                 <div class="form-group col-md-6">
                                <label for="eposta">* <?=$diller['teslimat-sayfa-form-eposta']?></label>
                                <div style="width: 100%; position: relative  ">
                                    <input type="text" name="eposta" value="<?=$adresRow['eposta']?>"  id="eposta"  class="form-control" autocomplete="off">
                                    <div class="teslimat-icon"><i class="fa fa-envelope-o"></i></div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tel">* <?=$diller['teslimat-sayfa-form-telefon']?></label>
                                <div style="width: 100%; position: relative; display: flex;  ">
                                    <div style="width: 15%; ">
                                        <div class="teslimat-icon-2">
                                            <span style="font-size: 16px ;">+</span>
                                        </div>
                                        <input type="number" name="alankodu" value="<?=$adresRow['alan_kodu']?>" class="form-control"autocomplete="off" style="padding-left: 22px;background-color: #f8f8f8; border-right: 1px solid #f8f8f8 ; " >
                                    </div>
                                    <div style="width: 85%;  ">
                                        <input type="text" name="tel" value="<?=$adresRow['telefon']?>"  id="tel"  class="form-control" autocomplete="off" placeholder="(___) ___-____" >
                                        <div class="teslimat-icon"><i class="fa fa-phone"></i></div>
                                    </div>
                                </div>
                            </div>
                            <?php }?>


                            <?php if( $odemeayar['faturasiz_teslimat'] == '1' ) {?>
                                <div class="form-group col-md-12">
                                    <label for="tcno"><?php if($odemeayar['faturasiz_tc_zorunlu'] == '1' ) { ?>*<?php }else{?>(<?=$diller['teslimat-sayfa-form-tc-opsiyonel']?>)<?php }?> <?=$diller['teslimat-sayfa-form-tc']?></label>
                                    <input type="number" name="tcno" value="<?=$adresRow['tc_no']?>"  id="tcno" <?php if($odemeayar['faturasiz_tc_zorunlu'] == '1' ) { ?><?php }?> class="form-control" autocomplete="off">
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
                                        <option value="<?=$adresRow['sehir']?>" selected><?=$adresRow['sehir']?></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ilce">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                                    <select name="ilce" id="ilce" class="form-control"  >
                                        <option value="<?=$adresRow['ilce']?>" selected><?=$adresRow['ilce']?></option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                                    <input type="text"  name="postakodu" placeholder="______"   id="postakodu" value="<?=$adresRow['postakodu']?>" maxlength="5"  class="form-control" autocomplete="off" >
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="adresbilgisi">* <?=$diller['teslimat-sayfa-form-adres']?></label>
                                    <textarea name="adresbilgisi" id="adresbilgisi" class="form-control" rows="2" ><?=$adresRow['adresbilgisi']?></textarea>
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
                                    <input type="text" name="il"  id="il" value="<?=$adresRow['sehir']?>" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ilce">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                                    <input type="text" name="ilce" value="<?=$adresRow['ilce']?>" id="ilce"  class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                                    <input type="text" name="postakodu"  placeholder="______"  id="postakodu" value="<?=$adresRow['postakodu']?>" maxlength="5" class="form-control" autocomplete="off" >
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="adresbilgisi">* <?=$diller['teslimat-sayfa-form-adres']?></label>
                                    <textarea name="adresbilgisi"  id="adresbilgisi" class="form-control" rows="2" ><?=$adresRow['adresbilgisi']?></textarea>
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
                                    <input type="text" name="ilce"  id="ilce" value="<?=$adresRow['ilce']?>"  class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                                    <input type="text" name="postakodu" placeholder="______"  id="postakodu" value="<?=$adresRow['postakodu']?>" maxlength="5"  class="form-control" autocomplete="off" >
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="adresbilgisi">* <?=$diller['teslimat-sayfa-form-adres']?></label>
                                    <textarea name="adresbilgisi" id="adresbilgisi" class="form-control" rows="2" ><?=$adresRow['adresbilgisi']?></textarea>
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
                                            <option value="<?=$ulke['3_iso']?>" ><?=$ulke['baslik']?></option>
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

                    <?php if($odemeayar['faturasiz_teslimat'] == '0' ) {?>
                        <div class="user_subpage_address_add_border_div" style="margin-left: 35px; ">
                            <div class="user_subpage_address_add_border_div_head">
                                <div class="user_subpage_address_add_border_div_head_in">
                                    <i class="las la-file-invoice"></i> <?=$diller['users-panel-text89']?>
                                </div>
                            </div>
                            <div class="teslimat-form-area">
                                <div class="teslimat-uyelik-tipi fatura-secim">
                                    <div class="rdio rdio-primary font-14 ">
                                        <input name="fatura_turu" value="fatura_turu1" id="fatura_turu1" type="radio" <?php if($adresRow['fatura_turu'] == '1' ) { ?>checked<?php }?>>
                                        <label for="fatura_turu1"><?=$diller['teslimat-sayfa-form-fatura-bireysel']?></label>
                                    </div>
                                    <div class="rdio rdio-primary font-14">
                                        <input name="fatura_turu" value="fatura_turu2" id="fatura_turu2" type="radio" <?php if($adresRow['fatura_turu'] == '2' ) { ?>checked<?php }?>>
                                        <label for="fatura_turu2"><?=$diller['teslimat-sayfa-form-fatura-kurumsal']?></label>
                                    </div>
                                </div>

                                <div class="fatura-secim-bireysel row" >
                                    <!-- Bireysel !-->
                                    <div class="form-group col-md-12">
                                        <label for="fatura_isim">* <?=$diller['teslimat-sayfa-form-isim']?></label>
                                        <input type="text" name="fatura_isim"  id="fatura_isim" value="<?=$adresRow['fatura_isim']?>" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="fatura_soyisim">* <?=$diller['teslimat-sayfa-form-soyisim']?></label>
                                        <input type="text" name="fatura_soyisim"  id="fatura_soyisim" value="<?=$adresRow['fatura_soyisim']?>" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="fatura_tc">* <?=$diller['teslimat-sayfa-form-tc']?></label>
                                        <input type="number" name="fatura_tc" placeholder="************" id="fatura_tc" value="<?=$adresRow['fatura_tc']?>" class="form-control" autocomplete="off">
                                    </div>
                                    <!-- Bireysel SON !-->
                                </div>


                                <div class="fatura-secim-kurumsal row" >
                                    <!-- Kurumsal !-->
                                    <div class="form-group col-md-12">
                                        <label for="fatura_firma_unvan">* <?=$diller['teslimat-sayfa-form-fatura-firma-unvan']?></label>
                                        <input type="text" name="fatura_firma_unvan"  id="fatura_firma_unvan" value="<?=$adresRow['fatura_firma_unvan']?>" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="fatura_vergi_dairesi">* <?=$diller['teslimat-sayfa-form-fatura-firma-vergidaire']?></label>
                                        <input type="text" name="fatura_vergi_dairesi"  id="fatura_vergi_dairesi" value="<?=$adresRow['fatura_vergi_dairesi']?>" class="form-control" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="fatura_vergi_no">* <?=$diller['teslimat-sayfa-form-fatura-firma-vergino']?></label>
                                        <input type="number" name="fatura_vergi_no"  id="fatura_vergi_no" value="<?=$adresRow['fatura_vergi_no']?>" class="form-control" autocomplete="off">
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
                                                <option value="<?=$adresRow['fatura_sehir']?>" selected><?=$adresRow['fatura_sehir']?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ilce2">* <?=$diller['teslimat-sayfa-form-ilce']?></label>
                                            <select name="fatura_ilce" id="ilce2" class="form-control">
                                                <option value="<?=$adresRow['fatura_ilce']?>" selected><?=$adresRow['fatura_ilce']?></option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="fatura_postakodu">* <?=$diller['teslimat-sayfa-form-postakodu']?></label>
                                            <input type="text" name="fatura_postakodu" placeholder="______"  id="fatura_postakodu" maxlength="5" value="<?=$adresRow['fatura_postakodu']?>" class="form-control" autocomplete="off" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="fatura_adresbilgisi">* <?=$diller['teslimat-sayfa-form-fatura-adres']?></label>
                                            <textarea name="fatura_adresbilgisi" id="fatura_adresbilgisi" class="form-control" rows="2" ><?=$adresRow['fatura_adresi']?></textarea>
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
                                            <input type="text" name="fatura_postakodu" placeholder="______"  id="fatura_postakodu" maxlength="5"  class="form-control" autocomplete="off" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="fatura_adresbilgisi">* <?=$diller['teslimat-sayfa-form-fatura-adres']?></label>
                                            <textarea name="fatura_adresbilgisi" id="fatura_adresbilgisi" class="form-control" rows="2" ></textarea>
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

                    <button class="button-blue button-2x m-top-10" style="width: 100%">
                        <?=$diller['users-panel-text97']?>
                    </button>

                </div>
            </form>
            <!--  <========SON=========>>> Adres Form Area SON !-->




        </div>
        <!--  <========SON=========>>> Right Content SON !-->



    </div>


</div>
<!-- CONTENT AREA ============== !-->



<?php include 'includes/template/footer.php'?>
</body>
</html>
    <script src="assets/js/phoneFormat.js"></script>
<?php include "includes/config/footer_libs.php";?>
    <?php if($_SESSION['adres_alert'] == 'empty'  ) {?>
        <div class="modal fade" id="noArea" data-backdrop="static" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['users-text10']?></div>
                        <div>
                            <?=$diller['users-text34']?>
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
                $('#noArea').modal('show');
            });
            $(window).load(function () {
                $('#noArea').modal('show');
            });
            var $modalDialog = $("#noArea");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['adres_alert'] ) ?>
    <?php }?>
    <?php if($_SESSION['adres_alert'] == 'eposta') {?>
        <div class="modal fade" id="errorModal" data-backdrop="static" style="z-index: 99999" >
            <div class="modal-dialog modal-dialog-centered modal-sm ">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" style="color: #000; position: absolute; right: 10px; top: 5px;">&times;</button>
                    <div style="background-color: #fff; color: #000; box-sizing: border-box; padding: 20px; text-align: center; font-size: 18px ;">
                        <i class="ion-ios-information-outline" style="font-size: 45px ; color: #558cff;"></i><br>
                        <div style="font-weight: bold; margin-bottom: 20px; font-size: 20px ; color: #558cff;"><?=$diller['alert-warning']?></div>
                        <div>
                            <?=$diller['alert-warning-eposta-hata']?>
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
                $('#errorModal').modal('show');
            });
            $(window).load(function () {
                $('#errorModal').modal('show');
            });
            var $modalDialog = $("#errorModal");
            $modalDialog.modal('show');

            setTimeout(function() {
                $modalDialog.modal('hide');
            }, 0);
        </script>
        <?php unset($_SESSION['adres_alert']); ?>
    <?php }?>
<?php if($_SESSION['adres_alert'] == 'tczorunlu'  ) {?>

    <div class="modal fade" id="tczorunlu" data-backdrop="static" >
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
    <?php unset($_SESSION['adres_alert'] ) ?>
<?php }?>


    <div id="shopButtonOverlay" style="font-family : '<?=$ayar['iletisim_sayfa_font']?>',Sans-serif ;">
        <div class="shopButtonT">
            <div><img src="images/load.svg" ></div>
            <div><?=$diller['teslimat-uye-text-4']?></div>
        </div>
    </div>
    <!-- Ülke seçimine göre şehir !-->
    <script type="text/javascript">
        $(document).ready(function(){ /* PREPARE THE SCRIPT */
            $("#ulke").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
                var ulke = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
                var dataString = "ulke="+ulke; /* STORE THAT TO A DATA STRING */

                $.ajax({ /* THEN THE AJAX CALL */
                    type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
                    url: "teslimat-ulke-data", /* PAGE WHERE WE WILL PASS THE DATA */
                    data: dataString, /* THE DATA WE WILL BE PASSING */
                    success: function(result){ /* GET THE TO BE RETURNED DATA */
                        $("#show").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
                    }
                });

            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){ /* PREPARE THE SCRIPT */
            $("#fatura_ulke").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
                var fatura_ulke = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
                var dataString = "fatura_ulke="+fatura_ulke; /* STORE THAT TO A DATA STRING */

                $.ajax({ /* THEN THE AJAX CALL */
                    type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
                    url: "teslimat-ulke-data-fatura", /* PAGE WHERE WE WILL PASS THE DATA */
                    data: dataString, /* THE DATA WE WILL BE PASSING */
                    success: function(result){ /* GET THE TO BE RETURNED DATA */
                        $("#show_fatura").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
                    }
                });

            });
        });
    </script>
    <!-- Ülke seçimine göre şehir SON !-->

    <!-- Text - to password !-->
    <script>
        $("#postakodu").keyup(function() {
            $("#postakodu").val(this.value.match(/[0-9]*/));
        });
        $("#fatura_postakodu").keyup(function() {
            $("#fatura_postakodu").val(this.value.match(/[0-9]*/));
        });
    </script>
    <!-- Text - to password SON !-->


    <!-- Fatura Tip seçimi !-->
    <script id="rendered-js">
        $('.fatura-secim input').change(function () {
            $(this).closest('.fatura-secim').next('.fatura-secim-bireysel').toggle(this.value == 'fatura_turu1').next('.fatura-secim-kurumsal').toggle(this.value == 'fatura_turu2');
        }).filter(':checked').change();
    </script>
    <script id="rendered-js">
        function checkMe(selected)
        {
            if (selected)
            {
                document.getElementById("faturagir").style.display = "";
            } else

            {
                document.getElementById("faturagir").style.display = "none";
            }

        }
    </script>
    <!-- Fatura Tip seçimi SON !-->
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>
