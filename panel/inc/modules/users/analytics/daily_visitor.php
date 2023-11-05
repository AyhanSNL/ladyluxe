<?php
/* Bugün verilerini çek */
$bugun = date("Y-m-d");
$bugunTekiLCek = $db->prepare("select * from ziyaretciler where tarih='$bugun' group by ipadres");
$bugunTekiLCek->execute();
$bugunTekiLCek_mobile = $db->prepare("select * from ziyaretciler where tarih='$bugun' and cihaz='mobile' group by ipadres");
$bugunTekiLCek_mobile->execute();
$bugunTekiLCek_desktop = $db->prepare("select * from ziyaretciler where tarih='$bugun' and cihaz='desktop' group by ipadres");
$bugunTekiLCek_desktop->execute();
/*  <========SON=========>>> Bugün verilerini çek SON */
?>    
<div class="border">
        <div class="card-body">
            <div>
                <h5><?=$diller['adminpanel-form-text-1422']?></h5>
                <p class="text-muted d-inline-block text-truncate w-100" style="font-size: 12px ;">
                    <?=$diller['adminpanel-form-text-1421']?>
                </p>
            </div>
            <div class="row">
                <div class="form-group col-md-4 text-center">
                    <div class="border ">
                        <h5><?=$bugunTekiLCek->rowCount()?></h5>
                        <p class="text-muted"><?=$diller['adminpanel-form-text-1423']?></p>
                    </div>
                </div>
                <div class="form-group col-md-4 text-center">
                    <div class="border border-primary">
                        <h5 class="text-primary"><?=$bugunTekiLCek_desktop->rowCount()?></h5>
                        <p class="text-primary"><i class="fas fa-desktop" style="font-size: 13px ;"></i> <?=$diller['adminpanel-form-text-1415']?></p>
                    </div>
                </div>
                <div class="form-group col-md-4 text-center">
                    <div class="border border-success">
                        <h5 class="text-success"><?=$bugunTekiLCek_mobile->rowCount()?></h5>
                        <p class="text-success"><i class="fas fa-mobile-alt" style="font-size: 13px ;"></i> <?=$diller['adminpanel-form-text-1414']?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
