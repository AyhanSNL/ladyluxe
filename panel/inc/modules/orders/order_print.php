<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if(isset($_GET['orderID']) && $_GET['orderID'] >'0' && $_GET['orderID'] == !null  ) {?>
    <?php
    $headerAyar = $db->prepare("select header_logo from header_ayar where id=:id ");
    $headerAyar->execute(array(
        'id' => '1'
    ));
    $head = $headerAyar->fetch(PDO::FETCH_ASSOC);

    $siparisCek = $db->prepare("select * from siparisler where siparis_no=:siparis_no ");
    $siparisCek->execute(array(
        'siparis_no' => $_GET['orderID'],
    ));
    $row = $siparisCek->fetch(PDO::FETCH_ASSOC);

    $sDurum = $db->prepare("select baslik from siparis_durumlar where id=:id ");
    $sDurum->execute(array(
        'id' => $row['siparis_durum'],
    ));
    $sdur = $sDurum->fetch(PDO::FETCH_ASSOC);


    $parabiriMi = $db->prepare("select * from para_birimleri where kod=:kod ");
    $parabiriMi->execute(array(
        'kod' => $row['parabirimi'],
    ));
    $para = $parabiriMi->fetch(PDO::FETCH_ASSOC);

    $ulkeler = $db->prepare("select baslik from ulkeler where 3_iso=:3_iso ");
    $ulkeler->execute(array(
        '3_iso' => $row['ulke'],
    ));
    $ulke = $ulkeler->fetch(PDO::FETCH_ASSOC);

    $ulkeler2 = $db->prepare("select baslik from ulkeler where 3_iso=:3_iso ");
    $ulkeler2->execute(array(
        '3_iso' => $row['fatura_ulke'],
    ));
    $ulke2 = $ulkeler2->fetch(PDO::FETCH_ASSOC);

    $urunliste = $db->prepare("select * from siparis_urunler where siparis_id=:siparis_id ");
    $urunliste->execute(array(
        'siparis_id' => $row['siparis_no'],
    ));

    if($siparisCek->rowCount()<='0'  ) {
        header('Location:'.$ayar['site_url'].'404');
        exit();
    }
    ?>
    <style>
        body{
            font-family : 'Open Sans', Sans-serif ;
        }
        .main{
            width: 100%;
            color: #000;
            border-bottom: 1px solid #EBEBEB;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .main-left{
            font-size: 14px ;
            font-weight: 600;
        }
        .main-right{

        }
        .middle{
            width: 100%;
            display: flex;
            align-items : flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .middle-box{
            width: 48%;
            margin-bottom: 25px;
        }
        .table-box {
            width: 100%;
            border: 1px solid #EBEBEB;
            border-collapse: collapse;
            font-size: 12px ;
        }
        .table-box tr{
            border: 1px solid #EBEBEB;
            padding: 6px;
        }
        .table-box td{
            border: 1px solid #EBEBEB;
            padding: 6px;
        }
        .middle-header{
            font-size: 14px ;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .td-left{
            font-weight: 500;
            width: 40%;
        }
        .dar-area{
            width: 13%;
        }
    </style>
    <title><?=$diller['adminpanel-form-text-1435']?> </title>

    <div class="main">
        <div class="main-left">
            <?=$ayar['site_baslik']?>
            <br>
            <?=$diller['adminpanel-form-text-1530']?>
        </div>
        <div>
            <img src="../images/logo/<?=$head['header_logo'] ?>" style="max-width: 135px;">
        </div>
        <div class="main-right">
            <img alt="testing" src="inc/barcode.php?text=<?=$row['siparis_no']?>&print=true" />
        </div>
    </div>
    <div class="middle">
        <div class="middle-box">
            <div class="middle-header"><?=$diller['adminpanel-form-text-1435']?></div>
            <div>
                <table class="table-box">
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-text-91']?></td>
                        <td><?=$row['siparis_no']?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1433']?></td>
                        <td><?=$row['isim']?> <?=$row['soyisim']?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1460']?></td>
                        <td><?php echo date_tr('j F Y, H:i', ''.$row['siparis_tarih'].''); ?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1434']?></td>
                        <?php if($row['odeme_tur'] =='1' ) {?>
                            <td><?=$diller['adminpanel-text-97']?></td>
                        <?php }?>
                        <?php if($row['odeme_tur'] =='2' ) {?>
                            <td><?=$diller['adminpanel-text-98']?></td>
                        <?php }?>
                        <?php if($row['odeme_tur'] =='3' ) {?>
                            <td><?=$diller['adminpanel-text-99']?></td>
                        <?php }?>
                        <?php if($row['odeme_tur'] =='4' ) {?>
                            <td><?=$diller['adminpanel-text-100']?></td>
                        <?php }?>
                        <?php if($row['odeme_tur'] =='free' ) {?>
                            <td><?=$diller['adminpanel-text-342']?></td>
                        <?php }?>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1438']?></td>
                        <td><?=$sdur['baslik']?></td>
                    </tr>
                    <?php if($row['siparis_notu'] == !null  ) {?>
                        <tr >
                            <td class="td-left"><?=$diller['adminpanel-form-text-1475']?></td>
                            <td><?=$row['siparis_notu']?></td>
                        </tr>
                    <?php }?>

                </table>
            </div>
        </div>
        <div class="middle-box">
            <div class="middle-header"><?=$diller['users-panel-text139']?></div>
            <div>
                <?php if($row['odeme_tur'] == '2' ) {?>
                    <table class="table-box">
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text140']?></td>
                            <td><?php echo number_format($row['havale_aratutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text141']?></td>
                            <td><?php echo number_format($row['havale_kdvtutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text149']?></td>
                            <td><?php echo number_format($row['havale_kargotutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                        <?php if($row['indirim_tutar'] >'0' ) {?>
                            <tr >
                                <td class="td-left"><?=$diller['users-panel-text142']?></td>
                                <td><?php echo number_format($row['indirim_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                            </tr>
                        <?php }?>
                        <?php if($row['kapida_odeme_bedeli'] >'0' ) {?>
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text143']?></td>
                            <td><?php echo number_format($row['kapida_odeme_bedeli'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                        <?php }?>
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text144']?></td>
                            <td><?php echo number_format($row['havale_toplamtutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                    </table>
                <?php }else { ?>
                    <table class="table-box">
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text140']?></td>
                            <td><?php echo number_format($row['ara_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text141']?></td>
                            <td><?php echo number_format($row['kdv_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text149']?></td>
                            <td><?php echo number_format($row['kargo_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                        <?php if($row['indirim_tutar'] >'0' ) {?>
                            <tr >
                                <td class="td-left"><?=$diller['users-panel-text142']?></td>
                                <td><?php echo number_format($row['indirim_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                            </tr>
                        <?php }?>
                        <?php if($row['kapida_odeme_bedeli'] >'0' ) {?>
                            <tr >
                                <td class="td-left"><?=$diller['users-panel-text143']?></td>
                                <td><?php echo number_format($row['kapida_odeme_bedeli'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                            </tr>
                        <?php }?>
                        <tr >
                            <td class="td-left"><?=$diller['users-panel-text144']?></td>
                            <td><?php echo number_format($row['toplam_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                        </tr>
                    </table>
                <?php }?>

            </div>
        </div>
        <div class="middle-box">
            <div class="middle-header"><?=$diller['adminpanel-form-text-1324']?></div>
            <div>
                <table class="table-box">
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-text-92']?></td>
                        <td><?=$row['isim']?> <?=$row['soyisim']?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-81']?></td>
                        <td><?=$row['telefon']?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-83']?></td>
                        <td><?=$row['eposta']?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1474']?></td>
                        <td><?=$row['postakodu']?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1326']?></td>
                        <td>
                            <?=$row['adresbilgisi']?>
                            <br>
                           <strong> <?=$row['ilce']?> / <?=$row['sehir']?> / <?=$ulke['baslik']?></strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="middle-box">
            <div class="middle-header"><?=$diller['adminpanel-form-text-1327']?></div>
            <div>
                <table class="table-box">
                    <?php if($row['adres_fatura_farkli'] == '0'  ) {?>
                        <tr >
                            <td class="td-left"><?=$diller['adminpanel-text-92']?></td>
                            <td><?=$row['isim']?> <?=$row['soyisim']?></td>
                        </tr>
                        <?php if($row['tc_no'] == !null  ) {?>
                            <tr >
                                <td class="td-left"><?=$diller['adminpanel-form-text-1316']?></td>
                                <td><?=$row['tc_no']?></td>
                            </tr>
                        <?php }?>
                        <tr >
                            <td class="td-left"><?=$diller['adminpanel-form-text-1474']?></td>
                            <td><?=$row['postakodu']?></td>
                        </tr>
                        <tr >
                            <td class="td-left"><?=$diller['adminpanel-form-text-1326']?></td>
                            <td>
                                <?=$row['adresbilgisi']?>
                                <br>
                                <strong> <?=$row['ilce']?> / <?=$row['sehir']?> / <?=$ulke['baslik']?></strong>
                            </td>
                        </tr>
                    <?php }else { ?>
                        <?php if($row['fatura_turu'] == '1'  ) {?>
                            <tr >
                                <td class="td-left"><?=$diller['adminpanel-text-92']?></td>
                                <td><?=$row['fatura_isim']?> <?=$row['fatura_soyisim']?></td>
                            </tr>
                            <tr >
                                <td class="td-left"><?=$diller['adminpanel-form-text-1316']?></td>
                                <td><?=$row['fatura_tc']?></td>
                            </tr>
                        <?php }else { ?>
                            <tr >
                                <td class="td-left"><?=$diller['adminpanel-form-text-1317']?></td>
                                <td><?=$row['fatura_firma_unvan']?></td>
                            </tr>
                            <tr >
                                <td class="td-left"><?=$diller['adminpanel-form-text-1318']?></td>
                                <td><?=$row['fatura_vergi_dairesi']?></td>
                            </tr>
                            <tr >
                                <td class="td-left"><?=$diller['adminpanel-form-text-1319']?></td>
                                <td><?=$row['fatura_vergi_no']?></td>
                            </tr>
                        <?php }?>
                        <tr >
                            <td class="td-left"><?=$diller['adminpanel-form-text-1474']?></td>
                            <td><?=$row['fatura_postakodu']?></td>
                        </tr>
                        <tr >
                            <td class="td-left"><?=$diller['adminpanel-form-text-1326']?></td>
                            <td>
                                <?=$row['fatura_adresi']?>
                                <br>
                                <strong> <?=$row['fatura_ilce']?> / <?=$row['fatura_sehir']?> / <?=$ulke2['baslik']?></strong>
                            </td>
                        </tr>
                    <?php }?>
                </table>
            </div>
        </div>
        <div class="middle-box" style="width: 100%;  ">
            <div class="middle-header"><?=$diller['adminpanel-form-text-1508']?> (<?=$urunliste->rowCount()?>)</div>
            <div>
                <table class="table-box">
                   <tr>
                       <td><?=$diller['adminpanel-form-text-940']?></td>
                       <td class="dar-area"><?=$diller['adminpanel-form-text-1518']?></td>
                       <td class="dar-area"><?=$diller['adminpanel-form-text-1519']?></td>
                       <td class="dar-area"><?=$diller['adminpanel-form-text-1199']?></td>
                       <td class="dar-area"><?=$diller['adminpanel-form-text-1423']?></td>
                   </tr>
                    <?php foreach ($urunliste as $urun) {
                        $varyant = $db->prepare("select * from siparis_varyant where urun_id=:urun_id and siparis_id=:siparis_id ");
                        $varyant->execute(array(
                            'urun_id' => $urun['urun_id'],
                            'siparis_id' => $row['siparis_no'],
                        ));
                        ?>
                        <tr>
                            <td>
                                <?=$urun['urun_baslik']?>
                                <!-- Varyantlar !-->
                                <?php if($varyant->rowCount()>'0'  ) {?>
                                    <br>
                                    <br>
                                        <?php foreach ($varyant as $var) {?>
                                            <?php if($var['tur'] != '2' && $var['tur'] != '4' ) {?>
                                                    <strong><?=$var['grup_adi']?>:</strong> <?=$var['varyant_adi']?>
                                                    <?php if($var['ek_fiyat'] >'0' ) {?>
                                                        [ + <?php echo number_format($var['ek_fiyat'], 2); ?> <?=$row['parabirimi']?> ]
                                                    <?php }?>
                                            <br>
                                            <?php }else {
                                                $varDetayBilgi = $db->prepare("select * from urun_varyant_ekler where id=:id ");
                                                $varDetayBilgi->execute(array(
                                                    'id' => $var['ekbilgi_id'],
                                                ));
                                                $ek = $varDetayBilgi->fetch(PDO::FETCH_ASSOC);

                                                ?>
                                                <?php if($varDetayBilgi->rowCount()>'0'  ) {?>
                                                <?php if($var['tur'] == '2' ) {?>
                                                    <strong><?=$var['grup_adi']?>:</strong> <?=$ek['icerik']?>
                                                    <?php if($var['ek_fiyat'] >'0' ) {?>
                                                        [ + <?php echo number_format($var['ek_fiyat'], 2); ?> <?=$row['parabirimi']?> ]
                                                    <?php }?>
                                                    <br>
                                                <?php }?>
                                                <?php if($var['tur'] == '4' ) {?>
                                                    <strong><?=$var['grup_adi']?>:</strong> <?php echo date_tr('j F Y', ''.$ek['icerik'].''); ?>
                                                    <?php if($var['ek_fiyat'] >'0' ) {?>
                                                        [ + <?php echo number_format($var['ek_fiyat'], 2); ?> <?=$row['parabirimi']?> ]
                                                    <?php }?>
                                                    <br>
                                                <?php }?>
                                                <?php }?>
                                            <?php }?>
                                        <?php }?>
                                <?php }?>
                                <!--  <========SON=========>>> Varyantlar SON !-->
                            </td>
                            <?php if($row['odeme_tur'] == '2' ) {?>
                                <td class="dar-area"><?php echo number_format($urun['havale_kdvsiz_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                                <td class="dar-area"><?php echo number_format($urun['havale_kdv_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                                <td class="dar-area"><?=$urun['adet']?></td>
                                <td class="dar-area"><?php echo number_format(($urun['havale_kdv_tutar']+$urun['havale_kdvsiz_tutar'])*$urun['adet'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                            <?php }else { ?>
                                <td class="dar-area"><?php echo number_format($urun['kdvsiz_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                                <td class="dar-area"><?php echo number_format($urun['kdv_tutar'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                                <td class="dar-area"><?=$urun['adet']?></td>
                                <td class="dar-area"><?php echo number_format(($urun['kdv_tutar']+$urun['kdvsiz_tutar'])*$urun['adet'], $para['para_format']); ?> <?=$row['parabirimi']?></td>
                            <?php }?>
                        </tr>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
    <script>
   window.onload = function() { window.print(); }
    </script>
<?php }else {
    header('Location:'.$ayar['site_url'].'404');
}?>