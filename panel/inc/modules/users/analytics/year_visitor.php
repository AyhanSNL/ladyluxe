<?php
$bugun = date("Y-m-d");
/* Bu Hafta verilerini çek */
$cevir = strtotime('-365 day',strtotime($bugun));
$buhafta = date("Y-m-d",$cevir);
$buhaftaTekilCek = $db->prepare("select * from ziyaretciler where tarih>='$buhafta' group by ipadres");
$buhaftaTekilCek->execute();
$buhaftaTekiLCek_mobile = $db->prepare("select * from ziyaretciler where tarih>='$buhafta' and cihaz='mobile' group by ipadres");
$buhaftaTekiLCek_mobile->execute();
$buhaftaTekiLCek_desktop = $db->prepare("select * from ziyaretciler where tarih>='$buhafta' and cihaz='desktop' group by ipadres");
$buhaftaTekiLCek_desktop->execute();
/*  <========SON=========>>> Bu Hafta verilerini çek SON */
?>    
<div class="border ">
        <div class="card-body">
            <div>
                <h5><?=$diller['adminpanel-form-text-1426']?></h5>
            </div>
            <div class="row mt-4">
                <div class="form-group col-md-4 text-center">
                    <div class="border ">
                        <h5><?=$buhaftaTekilCek->rowCount()?></h5>
                        <p class="text-muted"><?=$diller['adminpanel-form-text-1423']?></p>
                    </div>
                </div>
                <div class="form-group col-md-4 text-center">
                    <div class="border border-primary">
                        <h5 class="text-primary"><?=$buhaftaTekiLCek_desktop->rowCount()?></h5>
                        <p class="text-primary"><i class="fas fa-desktop" style="font-size: 13px ;"></i> <?=$diller['adminpanel-form-text-1415']?></p>
                    </div>
                </div>
                <div class="form-group col-md-4 text-center">
                    <div class="border border-success">
                        <h5 class="text-success"><?=$buhaftaTekiLCek_mobile->rowCount()?></h5>
                        <p class="text-success"><i class="fas fa-mobile-alt" style="font-size: 13px ;"></i> <?=$diller['adminpanel-form-text-1414']?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
