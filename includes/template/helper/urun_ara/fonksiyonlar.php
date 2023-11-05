<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$page_header_setting = $db->prepare("select * from page_header where page_id='arama' order by id");
$page_header_setting->execute();
$pagehead = $page_header_setting->fetch(PDO::FETCH_ASSOC);

$islemlerAyar = $db->prepare("select * from urun_cat_ayar where id='1'");
$islemlerAyar->execute();
$islemayar = $islemlerAyar->fetch(PDO::FETCH_ASSOC);

$urunKutuAyar = $db->prepare("select * from urun_kutu where id='1'");
$urunKutuAyar->execute();
$urunKutuRow = $urunKutuAyar->fetch(PDO::FETCH_ASSOC);

$search = trim(strip_tags($_GET['q']));

if(strip_tags(htmlspecialchars($_GET['q'])) != $_GET['q']  ) {
    header('Location:'.$ayar['site_url'].'404');
    exit();
}



/* Genel var mı yok mu */
$mainTotalCount = $db->prepare("select * from urun where gorunmez='0' and (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and durum='1' and dil='$_SESSION[dil]' ");
$mainTotalCount->execute();
/*  <========SON=========>>> Genel var mı yok mu SON */

/* Browser Link */
$browser_link = ''.$siteurl.'arama/';
$actual_link = ''.$ayar['protokol'].''.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'].'';
/*  <========SON=========>>> Browser Link SON */

/* Parsel Link */
$parse_url = $actual_link;
$parseParts = parse_url($parse_url);
$query = array();
parse_str($parseParts['query'], $query);

        /* Sıralama Parseli */
        $siralamaURL  = $parseParts['query'];
        $eski   = 's='.$query['s'].'';
        $yeni   = '';
        $siralamaURL = str_replace($eski, $yeni, $siralamaURL);
        /*  <========SON=========>>> Sıralama Parseli SON */

        /* Ücretsiz Kargo Parseli */
        $ukParselMain  = $parseParts['query'];
        $oldUKParselMain   = '&uk='.$query['uk'].'';
        $newUKParselMain   = '';
        $ukParselMain = str_replace($oldUKParselMain, $newUKParselMain, $ukParselMain);
        /*  <========SON=========>>> Ücretsiz Kargo Parseli SON */

        /* Yeni Ürünler Parseli */
        $npParselMain  = $parseParts['query'];
        $oldNPParselMain   = '&new='.$query['new'].'';
        $newNPParselMain   = '';
        $npParselMain = str_replace($oldNPParselMain, $newNPParselMain, $npParselMain);
        /*  <========SON=========>>> Yeni Ürünler Parseli SON */

        /* Yeni Ürünler Parseli */
        $npParselMain  = $parseParts['query'];
        $oldNPParselMain   = '&new='.$query['new'].'';
        $newNPParselMain   = '';
        $npParselMain = str_replace($oldNPParselMain, $newNPParselMain, $npParselMain);
        /*  <========SON=========>>> Yeni Ürünler Parseli SON */

        /* Fırsat Ürünleri Parseli */
        $opParselMain  = $parseParts['query'];
        $oldOPParselMain   = '&firsat='.$query['firsat'].'';
        $newOPParselMain   = '';
        $opParselMain = str_replace($oldOPParselMain, $newOPParselMain, $opParselMain);
        /*  <========SON=========>>> Fırsat Ürünleri Parseli SON */

        /* İndirimdekiler Parseli */
        $indirimParselMain  = $parseParts['query'];
        $oldIndirimParselMain   = '&indirim='.$query['indirim'].'';
        $newIndirimParselMain   = '';
        $indirimParselMain = str_replace($oldIndirimParselMain, $newIndirimParselMain, $indirimParselMain);
        /*  <========SON=========>>> İndirimdekiler Parseli SON */

        /* Taksitliler Parseli */
        $taksitParselMain  = $parseParts['query'];
        $oldTaksitParselMain   = '&taksit='.$query['taksit'].'';
        $newTaksitParselMain   = '';
        $taksitParselMain = str_replace($oldTaksitParselMain, $newTaksitParselMain, $taksitParselMain);
        /*  <========SON=========>>> Taksitliler Parseli SON */

        /* Hızlı Gönderi Parseli */
        $hkParselMain  = $parseParts['query'];
        $oldhkParselMain   = '&hizlikargo='.$query['hizlikargo'].'';
        $newHkParselMain   = '';
        $hkParselMain = str_replace($oldhkParselMain, $newHkParselMain, $hkParselMain);
        /*  <========SON=========>>> Hızlı Gönderi Parseli SON */

        /* Editörün Seçimi Parseli */
        $editorParselMain  = $parseParts['query'];
        $oldEditorParselMain   = '&editor='.$query['editor'].'';
        $newEditorParsel   = '';
        $editorParselMain = str_replace($oldEditorParselMain, $newEditorParsel, $editorParselMain);
        /*  <========SON=========>>> Editörün Seçimi Parseli SON */

        /* Stoktakiler Parseli */
        $StokParselMain  = $parseParts['query'];
        $oldSTOKParselMain   = '&stok='.$query['stok'].'';
        $newSTOKParselMain   = '';
        $StokParselMain = str_replace($oldSTOKParselMain, $newSTOKParselMain, $StokParselMain);
        /*  <========SON=========>>> Stoktakiler Parseli SON */


        /* Sayfalama Parseli */
        $sayfalamaParsel  = $parseParts['query'];
        $eskiPageParsel   = '&p='.$query['p'].'';
        $yeniPageParsel   = '';
        $sayfalamaParsel = str_replace($eskiPageParsel, $yeniPageParsel, $sayfalamaParsel);
        /*  <========SON=========>>> Sayfalama Parseli SON */


        /* Fiyat Range Parseli */
        $PriceFilterParselMain  = $parseParts['query'];
        $eskiRangeParsel   = '&max='.$query['max'].'&min='.$query['min'].'';
        $yeniRangeParsel   = '';
        $PriceFilterParselMain = str_replace($eskiRangeParsel, $yeniRangeParsel, $PriceFilterParselMain);
        /*  <========SON=========>>> Fiyat Range Parseli SON */


/*  <========SON=========>>> Parsel Link SON */


/* Sıralama Sorguları */

if ($_GET["s"] == '1') {
    $siralamaGet = "order by baslik asc";
}

if ($_GET["s"] == '2') {
    $siralamaGet = "order by fiyat asc";
}

if ($_GET["s"] == '3') {
    $siralamaGet = "order by fiyat desc";
}

if ($_GET["s"] == '4') {
    $siralamaGet = "order by id desc";
}

if ($_GET["s"] == '5') {
    $siralamaGet = "order by hit desc";
}
/*  <========SON=========>>> Sıralama Sorguları SON */

/* Sadece Filtreleri */
if ($_GET["uk"] == '1') {
    $ukFiltre = "and kargo='0'";
}
if ($_GET["new"] == '1') {
    $newFiltre = "and yeni='1'";
}
if ($_GET["firsat"] == '1') {
    $firsatFiltre = "and firsat='1'";
}
if ($_GET["indirim"] == '1') {
    $indirimFiltre = "and indirim='1'";
}
if ($_GET["taksit"] == '1') {
    $taksitFiltre = "and taksit='1'";
}
if ($_GET["editor"] == '1') {
    $editorFiltre = "and editor_secim='1'";
}
if ($_GET["hizlikargo"] == '1') {
    $hizlikargoFiltre = "and hizli_kargo='1'";
}
if ($_GET["stok"] == '1') {
    $stokvarFiltre = "and stok > '0'";
}
/*  <========SON=========>>> Sadece Filtreleri SON */



/* Maks Min Sorgusu */
if (isset($_GET["min"])) {
    $minimumfiyat = htmlspecialchars(trim($_GET['min']));
    $minFiltre = "and fiyat >= ".$minimumfiyat."";
}
if (isset($_GET["max"])) {
    $maximumfiyat = htmlspecialchars(trim($_GET['min']));
    $maxFiltre = "and fiyat <= ".$_GET['max']."+1";
}
/*  <========SON=========>>> Maks Min Sorgusu SON */
/* Kategori Listeleme */
$Sayfa = @intval($_GET['p']); if(!$Sayfa) $Sayfa = 1;
$Say = $db->prepare("select * from urun where (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and durum='1' and dil='$_SESSION[dil]' $ukFiltre $editorFiltre $newFiltre $firsatFiltre $indirimFiltre $taksitFiltre $hizlikargoFiltre $stokvarFiltre $minFiltre $maxFiltre $siralamaGet");
$Say->execute();
$TotalData = $Say->rowCount();
$Limit = $islemayar['urun_liste_limit'];
$Sayfa_Sayisi = ceil($TotalData/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster = $Sayfa * $Limit - $Limit;
$GorunenSayfa = 5;
$listeleSorgu = $db->prepare("select * from urun where (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and durum='1' and dil='$_SESSION[dil]' $ukFiltre $editorFiltre $newFiltre $firsatFiltre $indirimFiltre $taksitFiltre $hizlikargoFiltre $stokvarFiltre $minFiltre $maxFiltre $siralamaGet limit $Goster,$Limit");
$listeleSorgu->execute();
/*  <========SON=========>>> Kategori Listeleme SON */

/* Max-Min Fiyat Çekme Sorgusu */
if($userSorgusu->rowCount()>'0'  ) {
    if($uyegruplariCek->rowCount()>'0'  ) {
        $listeMaxPrice = $db->prepare("select * from urun where gorunmez='0' and (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and stok > '0'  and durum='1' and dil='$_SESSION[dil]' $ukFiltre $editorFiltre $newFiltre $firsatFiltre $indirimFiltre $taksitFiltre $hizlikargoFiltre $stokvarFiltre $minFiltre $maxFiltre order by fiyat desc limit 1  ");
        $listeMaxPrice->execute();
        $maxPriceCek = $listeMaxPrice->fetch(PDO::FETCH_ASSOC);

        $listeMinPrice = $db->prepare("select * from urun where gorunmez='0' and (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and stok > '0'  and  durum='1' and dil='$_SESSION[dil]' $ukFiltre $editorFiltre $newFiltre $firsatFiltre $indirimFiltre $taksitFiltre $hizlikargoFiltre $stokvarFiltre  $minFiltre $maxFiltre order by fiyat asc limit 1  ");
        $listeMinPrice->execute();
        $minPriceCek = $listeMinPrice->fetch(PDO::FETCH_ASSOC);
    }else{
        $listeMaxPrice = $db->prepare("select * from urun where gorunmez='0' and (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and stok > '0' and (fiyat_goster='2' or fiyat_goster='1')  and durum='1' and dil='$_SESSION[dil]' $ukFiltre $editorFiltre $newFiltre $firsatFiltre $indirimFiltre $taksitFiltre $hizlikargoFiltre $stokvarFiltre order by fiyat desc limit 1  ");
        $listeMaxPrice->execute();
        $maxPriceCek = $listeMaxPrice->fetch(PDO::FETCH_ASSOC);

        $listeMinPrice = $db->prepare("select * from urun where gorunmez='0' and (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and stok > '0' and (fiyat_goster='2' or fiyat_goster='1') and  durum='1' and dil='$_SESSION[dil]' $ukFiltre $editorFiltre $newFiltre $firsatFiltre $indirimFiltre $taksitFiltre $hizlikargoFiltre $stokvarFiltre  order by fiyat asc limit 1  ");
        $listeMinPrice->execute();
        $minPriceCek = $listeMinPrice->fetch(PDO::FETCH_ASSOC);
    }
}else{
    $listeMaxPrice = $db->prepare("select * from urun where gorunmez='0' and (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and stok > '0' and fiyat_goster='1' and durum='1' and dil='$_SESSION[dil]' $ukFiltre $editorFiltre $newFiltre $firsatFiltre $indirimFiltre $taksitFiltre $hizlikargoFiltre $stokvarFiltre order by fiyat desc limit 1  ");
    $listeMaxPrice->execute();
    $maxPriceCek = $listeMaxPrice->fetch(PDO::FETCH_ASSOC);

    $listeMinPrice = $db->prepare("select * from urun where gorunmez='0' and (baslik like '%$search%' or icerik like '%$search%' or spot like '%$search%' or tags like '%$search%' or meta_desc like '%$search%' or urun_kod like '%$search%' or meta_desc like '%$search%') and stok > '0' and fiyat_goster='1' and durum='1' and dil='$_SESSION[dil]' $ukFiltre $editorFiltre $newFiltre $firsatFiltre $indirimFiltre $taksitFiltre $hizlikargoFiltre $stokvarFiltre  order by fiyat asc limit 1  ");
    $listeMinPrice->execute();
    $minPriceCek = $listeMinPrice->fetch(PDO::FETCH_ASSOC);
}

    $minPrice = $minPriceCek['fiyat'];
    $maxPrice = $maxPriceCek['fiyat'];
/*  <========SON=========>>> Max-Min Fiyat Çekme Sorgusu SON */



?>