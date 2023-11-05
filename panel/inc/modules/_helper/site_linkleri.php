<?php 
$htmlSayfaCek = $db->prepare("select * from htmlsayfa where durum='1' and dil='$_SESSION[dil]' ");
$htmlSayfaCek->execute();
$kategoriSql = $db->prepare("select * from urun_cat where durum='1' and dil='$_SESSION[dil]' and ust_id='0' order by sira asc ");
$kategoriSql->execute();
$pricingKategorileriSql = $db->prepare("select * from pricing_kat where durum='1' and dil='$_SESSION[dil]' order by sira asc");
$pricingKategorileriSql->execute();
?>
    <option disabled style="font-weight: 600; color: #000 !important;" >----- <?=$diller['adminpanel-modul-link-normal']?> </option>
<option value="sss/" <?php if($urladdress == 'sss/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-1']?></option>
<option value="hesap-numaralarimiz/" <?php if($urladdress == 'hesap-numaralarimiz/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-2']?></option>
<option value="siparis-takip/" <?php if($urladdress == 'siparis-takip/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-3']?></option>
<option value="odeme-bildirimi/" <?php if($urladdress == 'odeme-bildirimi/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-4']?></option>
<option value="iletisim/" <?php if($urladdress == 'iletisim/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-5']?></option>
<option value="sepet/" <?php if($urladdress == 'sepet/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-6']?></option>
<option value="uye-girisi/" <?php if($urladdress == 'uye-girisi/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-7']?></option>
<option value="uyelik/" <?php if($urladdress == 'uyelik/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-8']?></option>
<option value="bildirimler/" <?php if($urladdress == 'bildirimler/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-9']?></option>
<option value="karsilastirmalar/" <?php if($urladdress == 'karsilastirmalar/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-10']?></option>
<option value="marka-listesi/" <?php if($urladdress == 'marka-listesi/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-11']?></option>
<option value="foto-galeri/" <?php if($urladdress == 'foto-galeri/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-12']?></option>
<option value="video-galeri/" <?php if($urladdress == 'video-galeri/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-13']?></option>
<option value="paketler/" <?php if($urladdress == 'paketler/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-14']?></option>
<option value="hizmetler/" <?php if($urladdress == 'hizmetler/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-15']?></option>
<option value="bloglar/" <?php if($urladdress == 'bloglar/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-16']?></option>
<option value="musteri-yorumlari/" <?php if($urladdress == 'musteri-yorumlari/'  ) { ?>selected<?php }?>><?=$diller['adminpanel-modul-link-17']?></option>
<?php if($htmlSayfaCek->rowCount()>'0'  ) {?>
    <option disabled  ></option>
    <option disabled style="font-weight: 600; color: #000 !important;" >----- <?=$diller['adminpanel-modul-link-html']?> </option>
<?php }?>
<?php foreach ($htmlSayfaCek as $sayfaRow) {?>
    <option value="sayfa/<?=$sayfaRow['seo_url']?>/" <?php if($urladdress == 'sayfa/'.$sayfaRow['seo_url'].'/') { ?>selected<?php }?>><?=$sayfaRow['baslik']?></option>
<?php }?>


<?php if($pricingKategorileriSql->rowCount()>'0'  ) {?>
    <option disabled  ></option>
    <option disabled style="font-weight: 600; color: #000 !important;" >----- <?=$diller['adminpanel-modul-link-pricing']?> </option>
    <?php foreach ($pricingKategorileriSql as $pric) {?>
        <option value="paket/<?=$pric['seo_url']?>/" <?php if($urladdress == 'paket/'.$pric['seo_url'].'/') { ?>selected<?php }?>><?=$pric['baslik']?></option>
    <?php }?>
<?php }?>

<?php if($kategoriSql->rowCount()>'0'  ) {?>
    <option disabled  ></option>
    <option disabled style="font-weight: 600; color: #000 !important;" >----- <?=$diller['adminpanel-modul-link-kategori']?> </option>
<?php }?>
<?php foreach ($kategoriSql as $katRow) {
    $kategoriSqlSub = $db->prepare("select * from urun_cat where durum='1' and dil='$_SESSION[dil]' and ust_id='$katRow[id]' order by sira asc ");
    $kategoriSqlSub->execute();
    ?>
    <option value="<?=$katRow['seo_url']?>/" <?php if($urladdress == $katRow['seo_url'].'/') { ?>selected<?php }?>><?=$katRow['baslik']?></option>
    <?php foreach ($kategoriSqlSub as $katSubRow) {
        $kategoriSqlSub_2 = $db->prepare("select * from urun_cat where durum='1' and dil='$_SESSION[dil]' and ust_id='$katSubRow[id]' order by sira asc ");
        $kategoriSqlSub_2->execute();
        ?>
        <option value="<?=$katSubRow['seo_url']?>/" <?php if($urladdress == $katSubRow['seo_url'].'/') { ?>selected<?php }?>><?=$katRow['baslik']?> -> <?=$katSubRow['baslik']?></option>
        <?php foreach ($kategoriSqlSub_2 as $katSub2Row) {
            $kategoriSqlSub_3 = $db->prepare("select * from urun_cat where durum='1' and dil='$_SESSION[dil]' and ust_id='$katSub2Row[id]' order by sira asc ");
            $kategoriSqlSub_3->execute();
            ?>
            <option value="<?=$katSub2Row['seo_url']?>/" <?php if($urladdress == $katSub2Row['seo_url'].'/') { ?>selected<?php }?>><?=$katRow['baslik']?> -> <?=$katSubRow['baslik']?> -> <?=$katSub2Row['baslik']?></option>
            <?php foreach ($kategoriSqlSub_3 as $katSub3Row) {?>
                <option value="<?=$katSub3Row['seo_url']?>/" <?php if($urladdress == $katSub3Row['seo_url'].'/') { ?>selected<?php }?>><?=$katRow['baslik']?> -> <?=$katSubRow['baslik']?> -> <?=$katSub2Row['baslik']?> -> <?=$katSub3Row['baslik']?></option>
            <?php }?>
        <?php }?>
    <?php }?>
<?php }?>




