<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php if(isset($_GET['orderID']) && $_GET['orderID'] >'0' && $_GET['orderID'] == !null  ) {?>
    <?php
    $headerAyar = $db->prepare("select header_logo from header_ayar where id=:id ");
    $headerAyar->execute(array(
        'id' => '1'
    ));
    $head = $headerAyar->fetch(PDO::FETCH_ASSOC);

    $siparisCek = $db->prepare("select * from siparis_normal where siparis_no=:siparis_no ");
    $siparisCek->execute(array(
        'siparis_no' => $_GET['orderID'],
    ));
    $row = $siparisCek->fetch(PDO::FETCH_ASSOC);

    $uruns = $db->prepare("select baslik from urun where id=:id ");
    $uruns->execute(array(
            'id' => $row['urun_id'],
    ));
    $urun = $uruns->fetch(PDO::FETCH_ASSOC);

    $sDurum = $db->prepare("select baslik from siparis_durumlar where id=:id ");
    $sDurum->execute(array(
        'id' => $row['durum'],
    ));
    $sdur = $sDurum->fetch(PDO::FETCH_ASSOC);

    $kargoFirmam = $db->prepare("select * from kargo_firma where id=:id ");
    $kargoFirmam->execute(array(
            'id' => $row['kargo_firma'],
    ));
    $kargo = $kargoFirmam->fetch(PDO::FETCH_ASSOC);


    $kaynak = $diller['adminpanel-bildirim-text-21'];
    $kaynak2 = $diller['adminpanel-bildirim-text-22'];


    $kaynak  = $kaynak;
    $eski   = ':';
    $yeni   = '';
    $kaynak = str_replace($eski, $yeni, $kaynak);
    $kaynak2  = $kaynak2;
    $eski2   = ':';
    $yeni2   = '';
    $kaynak2 = str_replace($eski2, $yeni2, $kaynak2);
    
    
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
            width: 100%;
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
            width: 30%;
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
                        <td class="td-left"><?=$diller['adminpanel-form-text-1545']?></td>
                        <td><?=$urun['baslik']?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1433']?></td>
                        <td><?=$row['isim']?> <?=$row['soyisim']?></td>
                    </tr>
                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1460']?></td>
                        <td><?php echo date_tr('j F Y, H:i', ''.$row['tarih'].''); ?></td>
                    </tr>

                    <tr >
                        <td class="td-left"><?=$diller['adminpanel-form-text-1438']?></td>
                        <td><?=$sdur['baslik']?></td>
                    </tr>
                    <?php if($row['siparis_not'] == !null  ) {?>
                        <tr >
                            <td class="td-left"><?=$diller['adminpanel-form-text-1475']?></td>
                            <td><?=$row['siparis_not']?></td>
                        </tr>
                    <?php }?>


                    <?php if($row['kargo_ver'] == '1' ) {?>
                    <tr >
                        <td class="td-left"><?=$kaynak?></td>
                        <td><?=$kargo['baslik']?></td>
                    </tr>


                    <tr >
                        <td class="td-left"><?=$kaynak2?></td>
                        <td><?=$row['kargo_takip']?></td>
                    </tr>
                    <?php }?>


                </table>
            </div>
        </div>
        <div class="middle-box">
            <div class="middle-header"><?=$diller['adminpanel-form-text-1548']?></div>
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
                        <?=$diller['adminpanel-form-text-1474']?> : <?=$row['postakodu']?>
                            <br><br>
                            <?=$row['adres']?>
                            <br>
                            <?=$row['sehir']?> / <?=$row['ulke']?>
                        </td>
                    </tr>
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