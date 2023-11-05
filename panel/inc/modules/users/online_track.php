<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
if ($yetki['ziyaretci_istatistik'] == '1') {

    $current_time = time();
    $timeout = $current_time - (80);
    $livePages = $db->prepare("select * from ziyaretci_online WHERE time>='$timeout' ");
    $livePages->execute();

    ?>
    <?php if ($livePages->rowCount() > '0') { ?>
        <div class="table-responsive " style="max-height: 500px !important;">
            <table class="table table-hover text-left mb-0 ">
                <thead class="thead-default">
                <tr>
                    <th><?=$diller['adminpanel-form-text-1411']?></th>
                    <th><?=$diller['adminpanel-form-text-1412']?></th>
                    <th><?=$diller['adminpanel-form-text-1413']?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($livePages as $live) {
                $sayfalarLive = $db->prepare("select * from ziyaretciler_adres where session=:session group by ip");
                $sayfalarLive->execute(array(
                    'session' => $live['session'],
                ));
                $says = $sayfalarLive->fetch(PDO::FETCH_ASSOC);
                ?>
                    <?php if($sayfalarLive->rowCount()>'0'  ) {?>
                        <tr >
                            <td>
                                <?php if($says['device'] == 'desktop' ) {?>
                                    <div class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-desktop"></i> <?=$diller['adminpanel-form-text-1415']?>
                                    </div>
                                <?php }else { ?>
                                    <div class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-mobile-alt"></i> <?=$diller['adminpanel-form-text-1414']?>
                                    </div>
                                <?php }?>
                            </td>
                            <td><?=$says['ip']?></td>
                            <td style="font-weight: bold;"><?=$says['url_adres']?></td>
                        </tr>
                    <?php }else { ?>
                        <tr >
                            <td>
                                <i class="fa fa-ban"></i>
                            </td>
                            <td></td>
                            <td style="font-weight: bold;"></td>
                        </tr>
                    <?php }?>
                <?php }?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="p-3" style="font-size: 16px ;">
            <div style="font-size: 40px ;">
                <i class="las la-chart-line"></i>
            </div>
            <?=$diller['adminpanel-form-text-1409']?>
        </div>
    <?php } ?>
    <?php
}else{
    header('Location:'.$ayar['site_url'].'404');
}
?>