<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
/* Ürün Verileri */
$veriCekUrun = $db->prepare("select * from urun where durum='1' and dil='$_SESSION[dil]' ");
$veriCekUrun->execute();
$urunData = $veriCekUrun->rowCount();
/*  <========SON=========>>> Ürün Verileri SON */
/* Üye Verileri */
$veriCekUye = $db->prepare("select * from uyeler ");
$veriCekUye->execute();
$uyeData = $veriCekUye->rowCount();
/*  <========SON=========>>> Üye Verileri SON */
/* Kategori Verileri */
$veriCekKat = $db->prepare("select * from urun_cat where dil='$_SESSION[dil]' ");
$veriCekKat->execute();
$catData = $veriCekKat->rowCount();
/*  <========SON=========>>> Kategori Verileri SON */
/* Yorum Verileri */
$veriCekYorum = $db->prepare("select * from urun_yorum where onay='1'");
$veriCekYorum->execute();
$yorumData = $veriCekYorum->rowCount();
/*  <========SON=========>>> Yorum Verileri SON */
?>
<div class="col-md-12 mb-3 d-flex align-items-center justify-content-between">
    <i class="fa fa-cubes text-warning" ></i>
    <div class="font-14 flex-grow-1" style="margin-left: 20px;"><?=$diller['adminpanel-text-70']?> </div>
    <div style="font-size: 16px ; font-weight: 600;"><?=$urunData?></div>
</div>
<div class="col-md-12 mb-3 d-flex align-items-center justify-content-between">
    <i class="fa fa-user text-warning"></i>
    <div class="font-14 flex-grow-1" style="margin-left: 20px; "><?=$diller['adminpanel-text-71']?> </div>
    <div style="font-size: 16px ; font-weight: 600;"><?=$uyeData?></div>
</div>
<div class="col-md-12 mb-3 d-flex align-items-center justify-content-between">
    <i class="fa fa-tag text-warning"></i>
    <div class="font-14 flex-grow-1" style="margin-left: 20px; "><?=$diller['adminpanel-text-72']?> </div>
    <div style="font-size: 16px ; font-weight: 600;"><?=$catData?></div>
</div>
<div class="col-md-12 d-flex align-items-center justify-content-between">
    <i class="fa fa-comment text-warning"></i>
    <div class="font-14 flex-grow-1" style="margin-left: 20px; "><?=$diller['adminpanel-text-73']?> </div>
    <div style="font-size: 16px ; font-weight: 600;"><?=$yorumData?></div>
</div>