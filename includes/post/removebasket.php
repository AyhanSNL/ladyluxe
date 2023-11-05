<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?>
<?php
//todo ioncube
$removeSorgu = $db->prepare("select * from sepet where sepetno=:sepetno ");
$removeSorgu->execute(array(
    'sepetno' => htmlspecialchars(trim($_GET['move']))
));
?>
<?php if($removeSorgu->rowCount() > '0'  ) {?>
    <?php

    /* Önce tür 2 varyant var ise onun varyant ekini sil */
    $sepet = $db->prepare("select * from sepet where sepetno=:sepetno ");
    $sepet->execute(array(
        'sepetno' => htmlspecialchars(trim($_GET['move']))
    ));
    $sep = $sepet->fetch(PDO::FETCH_ASSOC);

    $urunvaryantEkler = $db->prepare("select * from urun_varyant_ekler where sepet_id=:sepet_id and urun_id=:urun_id ");
    $urunvaryantEkler->execute(array(
        'sepet_id' => $sep['sepetno'],
        'urun_id' => $sep['urun_id']
    ));
    if($urunvaryantEkler->rowCount() >'0'  ) {

        $silmeislem_ekler = $db->prepare("DELETE from urun_varyant_ekler WHERE sepet_id=:sepet_id");
        $silmeislem_ekler->execute(array(
            'sepet_id' => htmlspecialchars(trim($_GET['move']))
        ));
    }
    /* Önce tür 2 varyant var ise onun varyant ekini sil SON */

    $silmeislem = $db->prepare("DELETE from sepet WHERE sepetno=:sepetno");
    $sil = $silmeislem->execute(array(
       'sepetno' => htmlspecialchars(trim($_GET['move']))
    ));
    if ($sil) {
           header('Location:'.$siteurl.'sepet/');
           unset($_SESSION['siparis_islem_id'] );
    }else {
        echo 'veritabanı hatası';
    }
    ?>
<?php }else { ?>
<?php
header('Location:'.$siteurl.'');
?>
<?php }?>
